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

class Testimonial extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;
    use HasStatuses;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'profession',
        'feedback',
        'feedback_short',
        'photo',
        'personal_data_agreement',
        'publish_agreement',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = ['profession', 'feedback', 'feedback_short'];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'name',
        'surname',
        'countryId',
        'status'
    ];

    /**
     * The possible values the publishing status can be.
     */
    const PUBLISHING_STATUS = [
        'unpublished' => 'unpublished',
        'published' => 'published',
    ];

    /**
     * Return the country of the teacher
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('author')
            ->saveSlugsTo('slug');
    }

    /**
     * Add Testimonial photo support using:
     * https://spatie.be/docs/laravel-medialibrary/v8/introduction
     * https://github.com/ebess/advanced-nova-media-library
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    /**
     * Testimonial full_name accessor.
     * $testimonial->full_name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
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
