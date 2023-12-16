<?php

namespace App\Collections;

use MongoDB\Laravel\Eloquent\Model;

class MenusCollection extends Model
{
    protected $collection = 'menus';

    protected $connection = 'mongodb';

    protected $fillable = ['menu_id', 'modules','category','parent_category', 'is_parents','is_child_category','is_active','created_at', 'updated_at'];
    protected $hidden = [
        'user_id',
    ];
}
