<?php

namespace App\Collections;

use MongoDB\Laravel\Eloquent\Model;

class AboutUsCollection extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'about_us';
    protected $fillable = [ 'aboutus_id','category','slug','title','sub_contents','page_content','module','is_active','created_date','updated_date'];
    protected $hidden = [
        'user_id',
    ];
    protected $dates = ['created_date','updated_date','datetime'];

}