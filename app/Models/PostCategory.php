<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PostCategory extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'description',
    ];

    // https://stackoverflow.com/questions/48264084/how-to-get-unique-slug-to-same-post-title-for-other-time-too
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function post(){
        return $this->hasMany(Post::class, 'category_id');  //  select * from post where category_id
    }




}
