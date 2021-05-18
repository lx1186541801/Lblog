<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Hash;
use Carbon\Carbon;
use Mail;
use DB;

class PasswordController extends Controller
{
    //
    //
    public function showLinkRequestForm()
    {
    	return view('auth.passwords.email');
    }


    public function sendResetLinkEmail(Request $request)
    {
    
    	$request->validate(['email' => 'required|email']);

    	$email = $request->email;

    	$user = User::where('email', $email)->first();

    	if (is_null($user)) {
    		session()->flash('danger', '邮箱未注册');
    		return redirect()->back()->withInput();
    	}

    	$token = hash_hmac('sha256', Str::random(40), config('app.key'));

    	// updateOrInsert 方法保持email唯一
    	DB::table('password_resets')->updateOrInsert(['email' => $email], [
    		'email' => $email,
    		'token' => Hash::make($token),
    		'created_at' => new Carbon,
    	]);

    	$view = "emails.reset_link";

    	Mail::send($view, compact('token'), function($message) use ($email) {
    		$message->to($email)->subject("忘记密码");
    	});

    	session()->flash('success', '重置邮件发送成功，请查收');
    	return redirect()->back();

    }

    public function showResetForm($token)
    {
    	
    	return view('auth.passwords.reset', compact('token'));
    }



    public function reset(Request $request)
    {
    	$request->validate([
    		'token' => 'required',
    		'email' => 'required|email',
    		'password' => 'required|confirmed|min:6'
    	]);

    	$email = $request->email;
    	$token = $request->token;


    	$expired = 60 * 10;

    	$user = User::where('email', $email)->first();


    	if (is_null($user)) {
    		session()->flash('danger', '邮箱未注册');
    		return redirect()->back()->withInput();
    	}

    	$record = DB::table('password_resets')->where('email', $email)->first();

    	if ($record) {
    		
    		if (Carbon::parse($record->created_at)->addSeconds($expired)->isPast()) {
    			session()->flash('danger', '链接已过期，请重新尝试');
    			return redirect()->route('password.request');
    		}

    		if ( ! Hash::check($token, $record->token)) {
    			session()->flash('danger', '令牌错误，请重新尝试');
    			return redirect()->back();
    		}

    		$user->update(['password' => bcrypt($request->password)]);

    		session()->flash('success', '密码重置成功，请使用新密码登陆');

    		return redirect()->route('login');
    	}


    	session()->flash('danger', '未找到重置记录');
    	return redirect()->back();
    }


}
