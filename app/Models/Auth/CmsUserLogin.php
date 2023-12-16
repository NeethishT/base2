<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class CmsUserLogin extends Model
{
 	protected $fillable = ['cms_user_id', 'ip', 'browser', 'platform', 'version', 'device'];
}
