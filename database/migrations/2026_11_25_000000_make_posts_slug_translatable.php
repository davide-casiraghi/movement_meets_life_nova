<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Turn the posts slug into a translatable (JSON) field, one slug per language
 * generated from the translated title.
 *
 * The old single slug is kept in `legacy_slug`, so the old addresses
 * (/{locale}/posts/{old-slug}) can be 301-redirected to the new ones.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('slug', 'legacy_slug');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('legacy_slug')->nullable()->change();
            $table->index('legacy_slug');
            $table->json('slug')->nullable()->after('publish_until');
        });

        $posts = DB::table('posts')->orderBy('id')->get(['id', 'title', 'legacy_slug']);

        // Slugs already assigned, per locale, to keep them unique within each language.
        $usedSlugs = [];
        $slugs = [];

        // First pass: where the old slug still matches the title of a language
        // (e.g. "my-title" or "my-title-2"), keep it, so that URL doesn't change.
        foreach ($posts as $post) {
            foreach ($this->titleSlugs($post) as $locale => $titleSlug) {
                if ($post->legacy_slug === $titleSlug
                    || preg_match('/^'.preg_quote($titleSlug, '/').'-\d+$/', (string) $post->legacy_slug)) {
                    $slugs[$post->id][$locale] = $post->legacy_slug;
                    $usedSlugs[$locale][$post->legacy_slug] = true;
                }
            }
        }

        // Second pass: generate the remaining slugs from the translated titles.
        foreach ($posts as $post) {
            foreach ($this->titleSlugs($post) as $locale => $titleSlug) {
                if (isset($slugs[$post->id][$locale])) {
                    continue;
                }

                $slug = $titleSlug;
                $suffix = 1;
                while (isset($usedSlugs[$locale][$slug])) {
                    $slug = $titleSlug.'-'.$suffix++;
                }

                $slugs[$post->id][$locale] = $slug;
                $usedSlugs[$locale][$slug] = true;
            }

            DB::table('posts')->where('id', $post->id)->update([
                'slug' => json_encode($slugs[$post->id] ?? [], JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    public function down(): void
    {
        // Posts created after the migration have no legacy slug: use their
        // Italian (or English) slug as the single slug.
        foreach (DB::table('posts')->whereNull('legacy_slug')->get(['id', 'slug']) as $post) {
            $slugs = json_decode((string) $post->slug, true) ?: [];
            DB::table('posts')->where('id', $post->id)->update([
                'legacy_slug' => $slugs['it'] ?? $slugs['en'] ?? (reset($slugs) ?: 'post-'.$post->id),
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropIndex(['legacy_slug']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('legacy_slug')->nullable(false)->change();
            $table->renameColumn('legacy_slug', 'slug');
        });
    }

    /**
     * The slug of the post title in each language it is translated into.
     *
     * @return array<string, string>
     */
    private function titleSlugs(object $post): array
    {
        $titles = json_decode((string) $post->title, true);

        if (! is_array($titles)) {
            return [];
        }

        return collect($titles)
            ->map(fn ($title) => Str::slug((string) $title))
            ->filter()
            ->all();
    }
};
