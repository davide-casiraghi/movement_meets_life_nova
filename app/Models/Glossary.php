<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Glossary extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;
    use HasStatuses;
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
     * The possible values the publishing status can be.
     */
    const PUBLISHING_STATUS = [
        'unpublished' => 'unpublished',
        'published' => 'published',
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
     * Set default status value when a glossary is created
     */
    public static function boot()
    {
        parent::boot();

        static::created(function (Glossary $glossary) {
            $glossary->setStatus('Published');
        });
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
}
