<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns the posts for a specific tag.
     */
    public function posts(){
        return $this->belongsToMany(Post::class);
    }

    /**
     * Returns the insight for a specific tag.
     */
    public function insights(){
        return $this->belongsToMany(Insight::class);
    }
}
