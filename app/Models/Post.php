<?php

namespace App\Models;

use App\Services\Helpers\CalculateReadingTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;  //used for Gallery field
use Spatie\MediaLibrary\HasMedia; //used for Gallery field
use Spatie\MediaLibrary\InteractsWithMedia; //used for Gallery field
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use HasFactory, HasSlug, HasTranslations, InteractsWithMedia;

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
    public $translatable = ['title','intro_text', 'body', 'introimage_alt'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // The saving / saved events will fire when a model is created or updated.
        static::saving(function ($model) {

            // Remove all malicious code (XSS) - http://htmlpurifier.org/  - https://github.com/mewebstudio/Purifier
            //$model->body = clean($model->get('body'));  //package mews/purifier was causing errors with strange characters in the body.. I have uninstalled it
            $model->created_by = Auth::id();

            // todo - Remove this: it's to allow the factory to generate without a null value.
            if (Auth::id() == null){
                $model->created_by = 1;
            }
        });
    }

    // https://stackoverflow.com/questions/48264084/how-to-get-unique-slug-to-same-post-title-for-other-time-too

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
     * Returns the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Returns the categories of the post.
     */
    public function post_category() {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    /**
     * Returns the insights related to the the post. (optional)
     */
    public function insights(){
        return $this->belongsToMany(Insight::class); //Many to Many
    }

    /**
     * Returns the tags associated to the post.
     */
    public function tags(){
        return $this->belongsToMany(Tag::class); //Many to Many
    }

    /**
     * Returns the reading time of the post.
     */
    public function reading_time(){
        return CalculateReadingTime::post_estimated_reading_time($this->body, 200);
    }

    /**
     * Add Image gallery support using:
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
        $this->addMediaCollection('introimage')->singleFile();
        $this->addMediaCollection('gallery');
    }


}
