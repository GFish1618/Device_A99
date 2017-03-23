<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\SocialProvider;
use App\User;

use Socialite;

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
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try
        {
            $socialUser = Socialite::driver('google')->user();
        }
        catch(\Exception $e)
        {
            return redirect('/');
        }

        $socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first();
        if (!$socialProvider)
        {
            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                ['name' => $socialUser->getName()],
                ['admin' => false]
            );

            $user->socialProviders()->create(
                ['provider_id' => $socialUser->getId(), 'provider' => 'google']
            );
            auth()->login($user);
            auth()->logout($user);
        }
        else
        {
            $user = $socialProvider->user;
            if($user->admin){
                auth()->login($user);
                return redirect('/device')->withOk("Access granted");;
            }
        }

        return redirect('/login')->withOk("Access refused, wait for admin");
    }
}
