<?php

namespace App\Models;

use App\Generators\PostStructuredDataScriptGenerator;
use App\Generators\StructuredDataScriptGeneratorInterface;
use App\Helpers\TextHelpers;
use App\Traits\HasStructuredData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia; //used for Gallery field
use Spatie\MediaLibrary\InteractsWithMedia; //used for Gallery field
use Spatie\MediaLibrary\MediaCollections\Models\Media; //used for Gallery field
use Spatie\ModelStatus\HasStatuses;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia, Searchable
{
    use HasFactory;
    use HasTranslatableSlug;
    use HasTranslations;
    use HasStatuses;
    use InteractsWithMedia;
    use HasStructuredData;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = ['title', 'slug', 'intro_text', 'body', 'introimage_alt'];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'title',
        'categoryId',
        'startDate',
        'endDate',
        'status',
    ];

    /**
     * The possible values the publishing status can be.
     */
    public const PUBLISHING_STATUS = [
        'unpublished' => 'unpublished',
        'published' => 'published',
    ];

    /**
     * Generates a unique slug for each language the title is translated into.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Returns the hidden post used to attach the images of the static pages
     * (Spatie media library needs a model to associate the media to).
     *
     * It is looked up by title only, so it is found whatever its category or
     * author are. If it doesn't exist yet it is created with the first category.
     */
    public static function staticPagesImages(): self
    {
        return static::firstOrCreate(
            ['title->en' => 'Static pages images'],
            [
                'intro_text->en' => 'Static pages images',
                'body->en' => 'Static pages images',
                'category_id' => PostCategory::query()->value('id'),
                'user_id' => 1,
            ]
        );
    }

    /**
     * Returns the author of the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the categories of the post.
     */
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    /**
     * Returns the insights related to the the post.
     */
    public function insights()
    {
        return $this->belongsToMany(Insight::class);
    }

    /**
     * Returns the tags associated to the post.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    /**
     * Returns the reading time of the post.
     *
     * @param string|null $format
     *
     * @return string
     */
    public function readingTime(string $format = null): string
    {
        return TextHelpers::estimateReadingTime($this->body, 200, $format);
    }

    /**
     * Add Image gallery support using:
     * https://spatie.be/docs/laravel-medialibrary/v8/introduction
     * https://github.com/ebess/advanced-nova-media-library
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);

        $this->addMediaConversion('facebook')
            ->width(1200)
            ->height(630);

        $this->addMediaConversion('twitter')
            ->width(1024)
            ->height(512);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('introimage')->singleFile();
        $this->addMediaCollection('images');
    }

    /**
     * Return true if the post is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->latestStatus('unpublished', 'published') == 'published';
    }

    /**
     * Return the post publishing status
     *
     * @return string
     */
    public function publishingStatus(): string
    {
        return $this->latestStatus('unpublished', 'published');
    }

    /**
     * Method required by Spatie Laravel Searchable
     */
    public function getSearchResult(): SearchResult
    {
        $url = route('posts.edit', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    /**
     * Get the specific structured data script generator.
     *
     * @return StructuredDataScriptGeneratorInterface
     */
    protected function getStructuredDataScriptGenerator(): StructuredDataScriptGeneratorInterface
    {
        return new PostStructuredDataScriptGenerator($this);
    }
}
