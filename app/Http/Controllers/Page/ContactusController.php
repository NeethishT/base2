<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ContactusController extends Controller
{
    public function __construct()
	{
		
        
	}

    public function index(Request $request)
    {
        $key=(empty($request->key)===false && $request->key) ? $request->key : '';
        if($key && $key == env('LOGIN_KEY')) {
        	return view('auth.login');
        } else {
            return redirect('/');
        }
    }
}
