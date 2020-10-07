<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRepeatType extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns the events that have this repeat type.
     */
    public function events(){                       // 1-to-many (one repeat type can have one or more events)
        return $this->hasMany(Event::class);  //  select * from events where event_repeat_type_id
    }
}
