<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model {

    use HasFactory, HasSlug, HasTranslations, HasStatuses;

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
            $testimonial->setStatus('Published');
        });
    }

    /**
     * Create status accessor
     */
    public function getStatusNamesAttribute()
    {
        return $this->status();
    }


}