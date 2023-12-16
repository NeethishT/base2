<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Vinkla\Hashids\Facades\Hashids;
use App\Exceptions\SuccessResponse;
use App\Exceptions\DefinedFault;
use Illuminate\Support\Facades\Cache;

if (!function_exists('encodeId')) {
    function encodeId($id): string
    {
        return Hashids::encode($id);
    }
}

if (!function_exists('decodeId')) {

    function decodeId($id): array
    {
        return Hashids::decode($id);
    }
}

function getPermissions()
{
	$cachePermissions = Redis::get('PERMISSIONS:' . Auth::user()->id);
	if (isset($cachePermissions)) {
		$rolePermission = json_decode($cachePermissions, false);
	} else {
		$permissions = Auth::user()->permissions;
        $rolePermission = [];
        if (empty($permissions) === false) {
            foreach ($permissions as $permission) {
                $rolePermission[] = $permission->slug;
            }
        }
	}
	return $rolePermission;
}

if (!function_exists('isDead')) {
    function isDead($value): bool
    {
        if (isset($value) && $value === 0){
            return false;
        }

        return empty($value);
    }
}

if (!function_exists('seeYou')) {
    function seeYou($data = [], $code = 200)
    {
        SuccessResponse::seeYou($data, $code);
    }
}
if (!function_exists('raiseError')) {

    /**
     * @throws DefinedFault
     */
    function raiseError($error = [], $code = 400)
    {
        throw new DefinedFault($error, $code);
    }
}