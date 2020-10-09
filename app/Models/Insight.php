<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Insight extends Model
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
    public $translatable = ['title', 'description'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_on_facebook_on',
        'published_on_twitter_on',
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
     * Returns the tags for the post.
     */
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Returns the post of the event.
     */
    public function post() {
        return $this->belongsTo(Post::class); // 1-to-1 (one event can have just one category)
    }

}
