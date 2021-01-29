<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Quote extends Model implements Searchable
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
    public $translatable = ['description'];

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('description')
            ->saveSlugsTo('slug');
    }

    /**
     * Set default status value when a quote is created
     */
    public static function boot()
    {
        parent::boot();

        static::created(function (Quote $quote) {
            $quote->setStatus('Published');
        });
    }

    /**
     * Method required by Spatie Laravel Searchable
     */
    public function getSearchResult(): SearchResult
    {
        $url = route('quotes.edit', $this->id);

        return new SearchResult(
            $this,
            $this->author . " " . $this->description,
            $url
        );
    }
}
