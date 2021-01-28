<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
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
    public $translatable = ['tag'];

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('tag')
            ->saveSlugsTo('slug');
    }

    /**
     * Returns the posts for a specific tag.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Returns the insight for a specific tag.
     */
    public function insights()
    {
        return $this->belongsToMany(Insight::class);
    }
}
