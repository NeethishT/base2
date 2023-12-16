<?php

namespace App\Models\Auth;

use App\Models\Auth\CmsRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPermission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'slug', 'is_active'
    ];


    public function roles()
    {
        return $this->belongsToMany(CmsRole::class, 'cms_user_roles')->withTimestamps();
    }
}
