<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\MailResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'last_login_time',
        'is_admin',
        'user_type',
        'created_by',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRoles()
    {
        return $this->hasMany(Role::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * Overide method send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }
}
