<?php

namespace App\Models\Auth;

use App\Models\Auth\CmsUserLogin;
use App\Models\Auth\CmsRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class CmsUser extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'cms_users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password', 'is_active', 'last_login', 'token'
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
        'last_login' => 'datetime'
    ];

    
    public function roles()
    {
        return $this->belongsToMany(CmsRole::class, 'cms_user_roles')
                    ->where('is_active', '=', true)
                    ->withTimestamps();
    }

    public function hasRole( ... $roles)
    {
        foreach ($roles as $role) {
          if ($this->roles->contains('slug', $role)) {
            return true;
          }
        }
        return false;
    }

    public function logins()
    {
        return $this->hasMany(CmsUserLogin::class);
    }

}
