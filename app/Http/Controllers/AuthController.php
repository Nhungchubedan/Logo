<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Mail\UserVerification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use App\Models\Account;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    public function login(Request $request) {
        if (auth()->check()) {

            return redirect()->intended('/');

        } else {
            if (request()->isMethod('post')) {
                
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required|min:8',
                ]);
                
                if ($validator->fails()) {
                    return back()->withErrors($validator->errors());
                }
    
                $account = Account::where('email', $request->email)->where('provider', 'System')->first();
                
                if (isset($account)) {
                    $hashedPassword = $account->password;
                }
                
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password]) && Hash::check($request->password, $hashedPassword)) {
                    Auth::login($account);
                    if (Auth::user()->role->role == 'User') {
                        return redirect()->intended('/');
                    };
                    return redirect()->route('admin.home');
                } else {
                    return back()->withErrors(['login' => 'Email hoặc mật khẩu không chính xác.']);
                }
                
    
            }

            return view('auth.login');
        }
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
    }


    public function handleGoogleCallback() {
        try {
            $socialiteUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            toastr()->error('Đăng nhập không thành công!');
            return redirect()->route('login');
        }

        $userSystem = Account::where('provider_id', $socialiteUser->id)->first();

        if (!isset($userSystem)) {
            $userSystem = Account::create([
                'user_name'     => $socialiteUser->name,
                'email'         => $socialiteUser->email,
                'id_role'       => 11105,
                'provider'      => 'Google',
                'provider_id'   => $socialiteUser->id,
                'confirm'       => 1,
                'id_image'      => null,
                'image_link'    => $socialiteUser->avatar
            ]);
        } 

        auth()->login($userSystem);

        return redirect()->route('welcome');
    }

    public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback() { 
        try {
            $socialiteUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            toastr()->error('Đăng nhập không thành công!');
            return redirect()->route('login');
        }

        $userSystem = Account::where('provider_id', $socialiteUser->id)->first();

        if (!isset($userSystem)) {
            $userSystem = Account::create([
                'user_name'     => $socialiteUser->name,
                'email'         => $socialiteUser->email,
                'id_role'       => 11105,
                'provider'      => 'Facebook',
                'provider_id'   => $socialiteUser->id,
                'confirm'       => 1,
                'id_image'      => null,
                'image_link'    => $socialiteUser->avatar_original
            ]);
        } 

        auth()->login($userSystem);

        return redirect()->route('welcome');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }


    public function register(Request $request) {
        if (request()->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'account_name' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required|min:8',
                'otp' => 'required|numeric|min:100000|max:999999',
            ]);
            
            $user = Account::where('email', $request->input('email'))->where('provider','System')->first();
            
            if (!$user) {
                return redirect()->back()->withErrors(['fail' => 'Tài khoản chưa được xác thực!' ]);
            }

            if ($request->input('otp') !== $user->confirmation_code) {
                $message = 'Mã OTP không hợp lệ!';
            } else if (Carbon::now()->gt($user->confirmation_code_expired_in)) {
                $message = 'Mã OTP đã hết hạn!';
            }

            if (isset($message)) {
                return back()->withErrors(['otp-info' => $message ]);
            }
            
            $user->update([
                'user_name'     => $request->input('account_name'),
                'password'      => Hash::make($request->input('password')),
                'confirm'       => true,
            ]);
            Auth::login($user);
            return redirect('/');
        }
        return view('auth.register');
    }

    public function sendOTP(Request $request) {
        $acc = Account::where('email', $request->email)->where('provider', 'System')->first();

        if ($acc) {
            if ($acc->confirm == true) {
                return response()->json(['message' => 'Email đã đăng ký!']);
            } else {
                $acc->update([
                    'confirmation_code' => rand(100000, 999999),
                    'confirmation_code_expired_in' => Carbon::now()->addSecond(180)
                ]);
                Mail::to($request->email)->send(new UserVerification($acc));
                return response()->json(['message' => 'Đã gửi lại mã OTP đến email của bạn.']);
            }
        } else {
            $user = Account::create([
                'id_role'   => 11105,
                'email'     => $request->email,
                'confirm'   => false,
                'confirmation_code' => rand(100000, 999999),
                'id_image'          => 000001,
                'confirmation_code_expired_in' => Carbon::now()->addSecond(180),

            ]);
            
            Mail::to($request->email)->send(new UserVerification($user));
            return response()->json([
                'message' => 'Mã đã được gửi đến email của bạn!',
            ]);
            
        }
    }

    public function forgot(Request $request) {
        if (request()->isMethod('post')) {

            $user = Account::where('email', $request->input('email'))->where('provider','System')->first();
            
            if (!isset($user)) {
                return redirect()->back()->withErrors(['email' => 'Email chưa đăng ký tài khoản!']);
            }

            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
                'token' => Str::random(60),
            ]);

            $token = $passwordReset->token;
            if ($passwordReset) {
                Mail::to($user->email)->send(new ResetPassword($passwordReset->token));
            }
    
            return redirect()->back()->with('status', 'Email thay đổi mật khẩu đã được gửi đến bạn!')->withInput(['email' => $request->input('email')]);

        }
        return view('auth.forgot-password');
    }

    public function reset(Request $request, $token) {
        $passwordReset = PasswordReset::where('token', $token)->first();
        
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(120)->isPast()) {
            $passwordReset->delete();
            return abort(422, 'This password reset token is invalid.');
        }

        if (request()->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|confirmed',  
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
        
            $user = Account::where('email', $passwordReset->email)->where('provider','System')->first();

            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);

            $passwordReset->delete();

            return redirect()->route('login');
        }

        
        return view('auth.reset-password');
    }
}
