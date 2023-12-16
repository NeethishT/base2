<?php

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Model;


class PassWordReset extends Model 
{
    protected $connection = 'mysql';  
    protected $table = 'password_resets';

}