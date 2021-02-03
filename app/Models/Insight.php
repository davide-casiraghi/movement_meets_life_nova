<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Insight extends Model
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;
    use HasStatuses;

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
    public $translatable = ['title', 'body', 'introimage_alt'];

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
     * The possible values the publishing status can be.
     */
    const PUBLISHING_STATUS = [
        'unpublished' => 'unpublished',
        'published' => 'published',
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
     * Return true if the insight is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->latestStatus('unpublished', 'published') == 'published';
    }

    /**
     * Return the insight publishing status
     *
     * @return string
     */
    public function publishingStatus(): string
    {
        return $this->latestStatus('unpublished', 'published');
    }
}
