<?php
namespace App\Utils;

use App\Models\Auth\CmsRolePermission;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

trait CommonUtils
{
    public $client;

    public function getGuzzleClient()
    {
        if (is_null($this->client)) {
            $this->client = app()->make(Client::class);
        }

        return $this->client;
    }
	
	public function generateUUID()
	{
		return md5(uniqid(rand(), true));
	}


    protected function permissionsCaching($user)
    {
    	$key = 'PERMISSIONS:'.$user->id;
    	$permissions = Redis::get($key);
    	if (empty($permissions) === false) {
    		$permissions = json_decode($permissions, true);
    	} else {
            $roleId = $user->roles[0]->id;
	        $permissions = [];
	        if (empty($roleId) === false) {
                $rolePermissions = CMSRolePermission::where('cms_role_id', '=', $roleId)
                        ->leftJoin('cms_permissions', 'cms_role_permissions.cms_permission_id', '=', 'cms_permissions.id')
                        ->get();
	        	if (empty($rolePermissions) === false) {
		            foreach ($rolePermissions as $permission) {
		                array_push($permissions, $permission->slug);
		            }
	        	}
	        }
            Redis::set($key, json_encode($permissions));
    	}

        return $permissions;
    }

    public function apiCall($url, $options = [], $method = 'GET') {

        try{

            $options['timeout'] = empty($options['timeout']) === false ? $options['timeout'] : 60;

            $response = $this->getGuzzleClient()->request($method, $url, $options);
            $this->statusCode = $response->getStatusCode();

            if ($response->getStatusCode() === 200) {
                return $response->getBody()->getContents();
            }
        } catch (\ClientException $e) {
            Log::error($e->getMessage());
        }

        return NULL;
    }

    public function removeFirstSlashString($filePath)
    {
        $pattern = '/^\//i';
        return preg_replace($pattern, '', $filePath);
    }
    

}
