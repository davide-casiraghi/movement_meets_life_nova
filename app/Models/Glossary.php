<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Glossary extends Model implements HasMedia, Searchable
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;
    use InteractsWithMedia;

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
    public $translatable = ['term','definition', 'body'];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'term',
        'is_published'
    ];

    /**
     * The possible values the publishing status can be.
     */
    public const PUBLISHING_STATUS = [
        0 => 'unpublished',
        1 => 'published',
    ];

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('term')
            ->saveSlugsTo('slug');
    }

    /**
     * Returns the variants of the glossary term.
     */
    public function variants()
    {
        return $this->hasMany(GlossaryVariant::class, 'glossary_id');
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
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('introimage')->singleFile();
    }

    /**
     * Return true if the glossary term is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Return the glossary term publishing status
     *
     * @return string
     */
    public function publishingStatus(): string
    {
        return self::PUBLISHING_STATUS[$this->is_published];
    }

    /**
     * Method required by Spatie Laravel Searchable
     */
    public function getSearchResult(): SearchResult
    {
        $url = route('glossaries.edit', $this->id);

        return new SearchResult(
            $this,
            $this->term,
            $url
        );
    }
}
