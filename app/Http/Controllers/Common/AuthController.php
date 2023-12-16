<?php
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Auth\CmsUserLogin;
use App\Models\Auth\PassWordReset;
use App\Models\Auth\CmsUser;
use Illuminate\Http\Request;
use App\Utils\TrackingTrait;
use Jenssegers\Agent\Agent;
use App\Utils\RememberMeExpiration;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use App\Utils\CommonUtils;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
	use RememberMeExpiration, TrackingTrait,CommonUtils;
    protected $maxLoginAttempts = 5;
    protected $lockoutTime = 300;

	public function __construct()
	{
		$this->middleware('guest')->except(['logout']);

	}

    public function login(Request $request)
    {
        $key=(empty($request->key)===false && $request->key) ? $request->key : '';
        if($key && $key == env('LOGIN_KEY')) {
        	return view('auth.login');
        } else {
            return redirect('/');
        }
    }

    public function validateLogin(LoginRequest $request, CmsUserLogin $cmsUserlogin)
    {
        
        if(str_contains($request->email , '@')){
            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];
        }else{
            $credentials = [
                'username' => $request->get('email'),
                'password' => $request->get('password'),
            ];
        }
        
        if(!Auth::validate($credentials)){
            return redirect()->to('/su/login')->with('error', 'Invalid login credentials.');
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if(empty($user->is_active) == true){
            return redirect()->to('/su/login')->with('error', 'Your account is in inactive mode. So please contact administrator.');
        }

        Auth::login($user, $request->get('rememberme') ? true : false);

        if($request->get('rememberme')){
            $this->setRememberMeExpiration($user);
        }

        $user->last_login =  Carbon::now();
        $user->save();

        $agent = new Agent();
        $browser = $agent->browser();
        $loginLog = $cmsUserlogin->create([
            'cms_user_id' => $user->id,
            'ip' => $this->getIp(),
            'browser' => $browser,
            'version' => $agent->version($browser),
            'platform ' => $agent->platform(),
            'device' => $agent->device()
        ]);

        return $this->authenticated($request, $user);
    }

    public function logout(Request $request) {
        $key = 'PERMISSIONS:'.Auth::user()->id;
        Redis::del($key);
	  	Auth::logout();
	  	return redirect(route('login'));
	}

	protected function authenticated(Request $request, $user)
    {
        $getPermissions = $this->permissionsCaching(auth()->user());
        $checkDashboardPermisson =  in_array("cms.users.dashboard",$getPermissions);
        if($checkDashboardPermisson === true){
            Session::flash('success', 'Welcome back '.$user->name);
            return redirect()->intended(route('cms.users.dashboard'));
        }else{
          foreach($getPermissions as $getPermission){
            Session::flash('success', 'Welcome back '.$user->name);
            return redirect()->intended(route($getPermission));
          }
        }
    }

    public function forgotPassword(Request $request,CmsUser $cmsuser)
    {
        return view('auth.forgot-password');
        
    }

    public function resetPasswordLink(Request $request,PassWordReset $passwordreset)
    {
        $request->validate([
              'email' => 'required|email|exists:cms_users'
          ]);
        $userDet = CmsUser::where('email',$request->email)->first();
        if(empty($userDet) === false){
            $token = Str::random(64);
            $passwordreset->insert([
              'email' => $userDet->email, 
              'token' => $token,
              'created_at' => Carbon::now()
            ]);
            $bodyContent ="You can reset password from bellow link: <br> <a href='".env('APP_URL')."/user-reset-password/token=".$token."' target='_blank'>".env('/APP_URL')."user-reset-password/token=".$token."</a>";
            $body = '<html><body>'.$bodyContent.'</body></html>';
            Log::info("mail request".json_encode($body)."user EMail  ".json_encode($userDet));
            $transport = (new \Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT')))
                            ->setUsername(env('MAIL_USERNAME'))    
                            ->setPassword(env('MAIL_PASSWORD'));   
            Log::info("mail credentials".json_encode($transport));                  
            $mailer = new \Swift_Mailer($transport);
            $message = (new \Swift_Message("We have e-mailed your password reset link!"))
            ->setFrom("no-reply@shriramfinance.in")
            ->setTo($userDet->email)
            ->setBody($body,'text/html');  
            Log::info("mail Message".($message));        
            $response = $mailer->send($message);
            Log::info("mail response".json_encode($response));
            if($response === 1){
                return redirect()->route('reset.request')->with('success', 'We have e-mailed your password reset link!');
            }else{
                return redirect()->route('reset.request')->with('error', 'error');
            }
        }else{
            return redirect()->route('reset.request')->withErrors(['email' => 'Email doesnt exist']);
        }
    }

    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink',compact('token'));
      }

    public function submitResetPasswordForm(Request $request,PassWordReset $passwordreset)
      {
          $request->validate([
              'email' => 'required|email|exists:cms_users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
          $updatePassword = PassWordReset::select('*')
                              ->where('email',$request->email)->orderBy('created_at','desc')->first();
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }  
          $user = CmsUser::where('email', $request->email)->update(['password' =>bcrypt($request->password)]);

        if($user === 1){
          return redirect()->route('login')->with('success', 'Your password has been changed!');
        }
        else{
            return redirect()->route('reset.submit')->with('success', 'Your password is not changed!');
        }
      }
       

}
