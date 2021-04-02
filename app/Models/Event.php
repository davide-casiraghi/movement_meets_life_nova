<?php

namespace App\Models;

use App\Traits\HasStructuredData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use HasStructuredData;

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
        'repeat_until',
    ];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'title',
        'eventCategoryId',
        'startDate',
        'endDate',
        'teacherId',
        'organizerId',
        'repetitionKindId',
        'venueId',
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
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id', 'id');
    }

    /**
     * Returns the venue of the event.
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class); // 1-to-1 (one event can have just one venue)
    }

    /**
     * Returns the teachers of the event.
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    /**
     * Returns the organizers of the event.
     */
    public function organizers()
    {
        return $this->belongsToMany(Organizer::class);
    }

    /**
     * Returns the repetitions of the event.
     */
    public function repetitions()
    {
        return $this->hasMany(EventRepetition::class);
    }

    /**
     * Get the repeat type of the event.
     */
    /*public function repeat_type() {
        return $this->belongsTo(EventRepeatType::class); // 1-to-1 (one event can have just one repeat type)
    }*/

    /**
     * Return the post publishing status
     *
     * @return string
     */
    public function publishingStatus(): string
    {
        return self::PUBLISHING_STATUS[$this->is_published];
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
     * Return true if the event is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Generate the script for an Event Schema.org type.
     *
     * @return Type
     */
    protected function generateStructuredDataScript(): Type
    {
        return Schema::danceEvent()
            ->name($this->title)
            ->description($this->description)
            ->if($this->hasMedia('introimage'), function (\Spatie\SchemaOrg\DanceEvent $schema) {
                $schema->image($this->getMedia('introimage')->first()->getUrl());
            })
            ->about($this->category->name)
            ->startDate($this->repetitions()->first()->start_repeat)
            ->endDate($this->repetitions()->first()->end_repeat)
            ->performer(Schema::person()
                ->name($this->teachers()->first()->name)
            )
            ->organizer(Schema::person()
                ->name($this->organizers()->first()->name)
                ->url($this->organizers()->first()->website)
            )
            ->location(Schema::place()
                ->name($this->venue->name)
                ->address(Schema::postalAddress()
                    ->streetAddress($this->venue->address)
                    ->addressLocality($this->venue->city)
                    ->addressRegion($this->venue->state_province)
                    ->postalCode($this->venue->zip_code)
                    ->addressCountry($this->venue->country->code)
                )
            );
    }
}
