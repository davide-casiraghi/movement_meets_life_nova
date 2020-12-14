<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Event extends Model
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
     * Return the user that created the event
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->belongsTo(Venue::class); // 1-to-1 (one event can have just one venue)
    }

    /**
     * Returns the teachers of the event.
     */
    public function teachers() {
        return $this->hasMany(Teacher::class);
    }

    /**
     * Returns the organizers of the event.
     */
    public function organizers() {
        return $this->hasMany(Organizer::class);
    }


    /**
     * Get the repeat type of the event.
     */
    /*public function repeat_type() {
        return $this->belongsTo(EventRepeatType::class); // 1-to-1 (one event can have just one repeat type)
    }*/

    /**
     * Set default status value when a event is created
     */
    public static function boot() {
        parent::boot();

        static::created(function (Event $event) {
            $event->setStatus('Published');
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
