<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Stevebauman\Location\Facades\Location;

class UserProfile extends Model implements Searchable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'user_id',
        'region_id',
        'work_type_id',
        'gender_id',
        'phone',
        'additional_information',
        'ip'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'validated_on' => 'datetime',
    ];

    /**
     * Return the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the region where the user is based
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Returns the work type of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workTypes()
    {
        return $this->belongsToMany(WorkType::class);
    }

    /**
     * Returns the gender of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genders()
    {
        return $this->belongsToMany(Gender::class);
    }

    /**
     * Return the regions for which the user want to receive the alerts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alertRegions()
    {
        return $this->belongsToMany(Region::class, 'alert_region_user_profile','user_profile_id', 'region_id');
    }

    /**
     * Return the regions for which the user want to receive the alerts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by', 'id');
    }

    /**
     * Get the location of the user
     *
     * @return bool|\Stevebauman\Location\Position
     */
    public function getLocationAttribute(){

        if (empty($this->attributes['ip'])) {
            return "No IP saved";
        }

        if (strpos($this->attributes['ip'], '192.168') === 0){
            return "User was created in local environment";
        }

        $location = Location::get($this->attributes['ip']);
        if($location){
            return $location->cityName.", ".$location->regionName.", ".$location->countryName;
        }

        return "No IP saved";
    }

    /**
     * Return true if the member has filled the profile with all the required data
     *
     * @return string
     */
    public function completed()
    {
        return $this->profile_completed_at != null;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

    /**
     * Method required by Spatie Laravel Searchable
     *
     */
    public function getSearchResult(): SearchResult {
        $url = route('members.edit', $this->id);

        return new SearchResult(
            $this,
            $this->name." ".$this->surname,
            $url
        );
    }


}
