<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the name login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ], [
            'name.required' => 'O campo Usuário é obrigatório.',
            'name.string' => 'O campo Usuário deve ser uma string.',
            'password.required' => 'O campo Senha é obrigatório.',
            'password.string' => 'O campo Senha deve ser uma string.',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'name' => [trans('auth.failed')],
        ]);
    }

    /**
     * Attempt to log the name into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        $user = User::where('name', $credentials['name'])->first();
    
        if ($user && $user->password === $credentials['password'] && $user->user_type === 'A') {
            Auth::login($user);
            return true;
        }
        
        return false;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            'name' => strtoupper($request->get('name')),
            'password' => md5($request->get('password')),
        ];
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function loginApi(Request $request)
    {
        $credentials = $this->credentials($request);

        $user = User::where('name', $credentials['name'])->first();

        if ($user && $user->password === $credentials['password'] && $user->user_type === 'A') {
            Auth::login($user);
            $token = $user->createToken('TokenName')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }else{
            if ($user ){
                return response()->json(['error' => 'senha inválida'], 401);
            }else{
                return response()->json(['error' => 'usuário não encontrado'], 401);
                
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
