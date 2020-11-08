<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;

class Comment extends Model
{
    use HasFactory, HasStatuses;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Set default status value when a comment is created
     */
    public static function boot() {
        parent::boot();

        static::created(function (Comment $comment) {
            $comment->setStatus('Published');
        });
    }


}
