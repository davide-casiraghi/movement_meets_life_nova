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

    use HasFactory, HasSlug, HasTranslations, HasStatuses, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'profession',
        'feedback',
        'photo',
        'personal_data_agreement',
        'publish_agreement',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = ['profession', 'feedback'];

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom('author')
            ->saveSlugsTo('slug');
    }

    /**
     * Set default status value when a testimonial is created
     */
    public static function boot() {
        parent::boot();

        static::created(function (Testimonial $testimonial) {
            $testimonial->setStatus('Pending');
        });
    }

    /**
     * Create status accessor
     */
    public function getStatusNamesAttribute()
    {
        return $this->status();
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


}