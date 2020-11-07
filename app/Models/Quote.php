<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Quote extends Model
{
    use HasFactory, HasSlug, HasTranslations, HasStatuses;

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
    public $translatable = ['description'];

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('description')
            ->saveSlugsTo('slug');
    }

    /**
     * Set default status value when a quote is created
     */
    public static function boot() {
        parent::boot();

        static::created(function (Quote $quote) {
            $quote->setStatus('Published');
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
