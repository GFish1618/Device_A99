<?php

namespace App\Http\Controllers\Auth;

session_start();
$_SESSION['nbp'] = 5;
$_SESSION['orderby'] = 'id';
$_SESSION['search_crit'] = array();

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Repositories\GoogleAuth;

use App\SocialProvider;
use App\User;
use \Google_Client; 
use \Google_Service_Drive;

use Socialite;
use Excel;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        $googleClient = new Google_Client();
        $googleAuth = new GoogleAuth($googleClient);

        return redirect($googleAuth->getAuthUrl());
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $googleClient = new Google_Client();
        $googleAuth = new GoogleAuth($googleClient);

        if($googleAuth->checkRedirectCode())
        {
            
            $socialUser = $googleAuth->getProfile();

            if (! preg_match("/@august99.com$/", $socialUser['email']))
            {
                return redirect('/login')->withOk("Invalid Email");
            }
            else
            {
                $socialProvider = SocialProvider::where('provider_id', $socialUser['id'])->first();
                if (!$socialProvider)
                {
                    $user = User::firstOrCreate(
                        ['email' => $socialUser['email']],
                        ['name' => $socialUser['name']]
                    );

                    if (isset($socialUser['nickname']))
                    {
                        $user->nickname = $socialUser['nickname'];
                    }
                    else
                    {
                        $user->nickname = $user->name;
                    }

                    $user->avatar = $socialUser['picture'];
                    $user->admin = 0;

                    //$user->remember_token = $socialAuth->client->getRefreshToken();
            
                    $user->save();

                    $user->socialProviders()->create(
                        ['provider_id' => $socialUser['id'], 'provider' => 'google']
                    );
                    auth()->login($user);
                    auth()->logout($user);
                }
                else
                {
                    $user = $socialProvider->user;
                    $user->avatar = $socialUser['picture'];
                    //$user->remember_token = $googleAuth->client->getRefreshToken();

                    $user->save();
                }
                auth()->login($user);
                return redirect('/device')->withOk("Access granted");
            }
            
            return redirect('/login')->withOk("Access refused, wait for admin");

        }
    }

    
}
