<?php

namespace App\Models;

use App\Helpers\TextHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;  //used for Gallery field
use Spatie\MediaLibrary\HasMedia; //used for Gallery field
use Spatie\MediaLibrary\InteractsWithMedia; //used for Gallery field
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasTranslations ;
    use HasStatuses;
    use InteractsWithMedia;

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
     * The possible values the publishing status can be.
     */
    const PUBLISHING_STATUS = [
        'unpublished' => 'unpublished',
        'published' => 'published',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // The saving / saved events will fire when a model is created or updated.
        static::saving(function ($model) {
            $model->created_by = Auth::id();

            // todo - Remove this: it's to allow the factory to generate without a null value.
            if (Auth::id() == null) {
                $model->created_by = 1;
            }
        });
    }

    // https://stackoverflow.com/questions/48264084/how-to-get-unique-slug-to-same-post-title-for-other-time-too

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
     * Returns the author of the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Returns the categories of the post.
     */
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    /**
     * Returns the insights related to the the post.
     */
    public function insights()
    {
        return $this->belongsToMany(Insight::class);
    }

    /**
     * Returns the tags associated to the post.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    /**
     * Returns the reading time of the post.
     *
     * @param string|null $format
     *
     * @return string
     */
    public function readingTime(string $format = null): string
    {
        return TextHelpers::estimateReadingTime($this->body, 200, $format);
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
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('introimage')->singleFile();
        $this->addMediaCollection('gallery');
    }

    /**
     * Return true if the post is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->latestStatus('unpublished', 'published') == 'published';
    }

    /**
     * Return the post publishing status
     *
     * @return string
     */
    public function publishingStatus(): string
    {
        return $this->latestStatus('unpublished', 'published');
    }
}
