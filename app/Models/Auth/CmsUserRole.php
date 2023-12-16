<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class CmsUserRole extends Model
{
    protected $fillable = [
        'cms_role_id', 'cms_user_id'
    ];
}
