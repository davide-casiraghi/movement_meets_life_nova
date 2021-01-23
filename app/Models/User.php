<?php

namespace App\Models;

use App\Models\UserProfile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasStatuses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected array $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The possible values the status can be.
     */
    const STATUS = [
        'disabled' => 'disabled',
        'enabled' => 'enabled',
    ];

    /**
     * Returns the posts written by this user.
     */
    public function post()
    {
        return $this->hasMany(Post::class, 'created_by');  //  select * from post where created_by
    }

    /**
     * Returns the the user profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Return true if the user is an administrator
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Returns the events crated by this user.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Returns the events crated by this user.
     */
    public function organizers()
    {
        return $this->hasMany(Organizer::class);
    }

    /**
     * Returns the events crated by this user.
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    /**
     * Return true if the post is published
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->latestStatus('disabled', 'enabled') == 'enabled';
    }

    /**
     * Return the user level (Super Admin or Admin)
     *
     * @return string
     */
    public function level(): string
    {
        if ($this->hasRole(['Super Admin'])) {
            return 'Super Admin';
        }
        if ($this->hasRole(['Admin'])) {
            return 'Admin';
        }

        return '';
    }

}
