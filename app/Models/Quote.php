<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'author',
        'description',
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
            ->generateSlugsFrom('description')
            ->saveSlugsTo('slug');
    }

    /**
     * Return true if the quote is public
     * Public means that it's snown in the frontent to the users
     * When is private it's shown just in the backend
     *
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * Return true if the quote is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Return the quote publishing status
     *
     * @return string
     */
    public function publishingStatus(): string
    {
        return self::PUBLISHING_STATUS[$this->is_published];
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
