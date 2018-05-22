<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

	protected $repository;

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
    protected $redirectTo = '/';

	public function login(\Illuminate\Http\Request $request) {
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

		$authenticated = false;
		try {
			$users = $this->repository->findWhere('name', $request['name']);
			if ($users->isNotEmpty()) {
				if ($users[0]->ldap_login) {
					$guardName = 'adldap';
				} else {
					$guardName = 'web';
				}
				if (Auth::guard($guardName)->attempt($this->credentials($request), $request->filled('remember'))) {

					//$user = Auth::user();
					if ($users[0]->ldap_login) {
						if (isset($request['remember'])) {
							Auth::login($users[0], true);
						} else {
							Auth::login($users[0], false);
						}
					}
					// Returns user model configured in `config/auth.php`.
					return $this->sendLoginResponse($request);
				} else {
					Log::info('redirect to login with errors....');
					// $errorMessages = new \Illuminate\Support\MessageBag;
					// $errorMessages->add('name', 'Valide contraseña.');
					return $this->sendFailedLoginResponse($request);
					//view('auth.login', ['errors' => $errorMessages]);
				}
			} else {
				Log::info('redirect to login with errors....');
				// $errorMessages = new \Illuminate\Support\MessageBag;
				// $errorMessages->add('name', 'Valide contraseña.');
				return $this->sendFailedLoginResponse($request);
				//view('auth.login', ['errors' => $errorMessages]);
			}
		} catch (ModelNotFoundException $e) {
			Log::info('redirect to login with errors....');
			// $errorMessages = new \Illuminate\Support\MessageBag;
			// $errorMessages->add('name', 'Valide contraseña.');
			return $this->sendFailedLoginResponse($request);
			//view('auth.login', ['errors' => $errorMessages]);
		}
	}

	 /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();

		if (isset($user) && $user->ldap_login) {
			$guardName = 'adldap';
		} else {
			$guardName = 'web';
		}

		$this->guard($guardName)->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

	public function username()
	{
		return 'name';
	}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\UserRepository $repository)
    {
		$this->repository = $repository;
        $this->middleware('guest')->except('logout');
    }
}
