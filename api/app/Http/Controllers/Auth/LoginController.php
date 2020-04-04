<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Socialite\Facades\Socialite;

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

    protected $redirectTo = '/home';
    public function showLoginForm(){
        throw new UnauthorizedException('Brak użytkownika');
    }

    public function field(Request $request)
    {
        $login = $request->login;
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        request()->merge([$fieldType => $login]);
        return 'email';
    }
    public function logout(Request $request)
    {
        $request->user('api')->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    public function login(Request $request)
    {
        $field = $this->field($request);
        $request->validate([
            $field => 'required|string|exists:users',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request([$field, 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => [
                    'password' => ['Password not match']
                ]
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function redirectExternal(Request $request, $type){
        return Socialite::driver($type)->redirect();
    }
    public function externalCallback(Request $request, $type){
        $user = Socialite::driver($type)->stateless()->user();
        try{
            if($existed = User::where('email', $user->getEmail())->where('is_'.$type, 1)->first()){
                $new_user = $existed;
            }else{
                $new_user = User::create([
                    'login' => $user->getEmail(),
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'is_facebook' => ($type == 'facebook')? true : false,
                    'is_google' => ($type == 'google')? true : false,
                    'password' => Hash::make('password'),
                    'avatar' => $user->getAvatar()
                ]);
            }

        }catch(\Exception $e){
            return redirect()->to(config('app.admin_url').'login?error=Błąd podczas tworzenia użytkownika, użytkownik o takim adresie email może już istnieć');
        }
        $tokenResult = $new_user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return redirect()->to(config('app.admin_url').'auth?token='.$tokenResult->accessToken);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
