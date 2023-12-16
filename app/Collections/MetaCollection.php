<?php

namespace App\Collections;

use MongoDB\Laravel\Eloquent\Model;

class MetaCollection extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'meta';
    protected $fillable = ['meta_id','slug','module','sub_module','title','meta_title','meta_description','meta_keywords','is_active','is_product','created_at' => 'string', 'updated_at'=> 'string'];
    protected $hidden = [
        'user_id',
    ];
    protected $dates = ['created_at','updated_at','datetime'];
}
