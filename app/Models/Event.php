<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_start',
        'date_end',
    ];

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Returns the category of the event.
     */
    public function category() {
        return $this->belongsTo(EventCategory::class); // 1-to-1 (one event can have just one category)
    }

    /**
     * Returns the venue of the event.
     */
    public function venue() {
        return $this->belongsTo(EventVenue::class); // 1-to-1 (one event can have just one venue)
    }

    /**
     * Get the repeat type of the event.
     */
    public function repeat_type() {
        return $this->belongsTo(EventRepeatType::class); // 1-to-1 (one event can have just one repeat type)
    }
}
