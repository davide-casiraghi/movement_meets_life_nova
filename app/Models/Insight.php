<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Insight extends Model implements HasMedia, Searchable
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_on_facebook_on',
        'published_on_twitter_on',
        'published_on_instagram_on'
    ];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'title',
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
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Returns the tags associated to the insight.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Returns the posts related to the insight. (optional)
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class); // Many to many
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
    }

    /**
     * Return true if the insight is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Return the insight publishing status
     *
     * @return string
     */
    public function publishingStatus(): string
    {
        return self::PUBLISHING_STATUS[$this->is_published];
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('insights.edit', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
