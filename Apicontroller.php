<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon; 
use Mail;
use App\Mail\verificationMail;
use Illuminate\Support\Facades\Redirect;
class Apicontroller extends Controller
{
    public function signup_process1(Request $request){
        //dd($request);
        $validated = array(
            'name' => 'required',
            'email' => 'required|unique:Users|max:50',
            'password' => 'required',
        );
        $rules = Validator::make($request->all(),$validated);
        if($rules->fails())
        {
        return response(['errors'=>$rules->errors()->all()], 422);
        }
        else
        {
        $create = new User;  
        $create->name = $request->name;
        $create->email = $request->email;
        $create->password = Hash::make($request->password);
        $create->save();

        $details = [
            'title' => 'Title: Mahatat Al Alam',
            'body' => [
                'email' => $request->email,
                'password' => $request->password,
         ]
        ];

        \Mail::to($request->email)->send(new verificationMail($details));
        $token_result = $create->createToken('dow-api')->plainTextToken;
        return response()->json(['result'=>$token_result,'message'=>'Use this exact token and do verify you account through email which we have send to you!']);
        }
    }
    public function verify_process(Request $request){
        //dd($request);
        \DB::table('users')
                ->where('email', $request->email)
                ->update(['email_verified_at' => 1]);
    }
    public function login_process1(Request $request){
        //dd($request);
        $validated = array(
            'email'=>'required',
            'password' => 'required',
        );
        $rules = Validator::make($request->all(),$validated);
        if($rules->fails())
        {
        return response(['errors'=>$rules->errors()->all()], 422);
        }
        else
        {
        $creditionals = request(['email','password']);
        if (!Auth::guard('web')->attempt($creditionals))
        {
        return response()->json(['message'=>'Please enter the corect credentials!']);
        }
        else
        {
        $user = User::where('email',$request->email)->first();
        //$token_result=$agent->createToken('dow-app')->plainTextToken;
        return response()->json(['user'=>$user,'message'=>'you are logged in!']);
        }
        }
}
    public function logout1(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'User is logged out Successfully!!']);
    }
    public function submitForgetPassword(Request $request)
    {
        //dd($request);
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(64);
        \DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
        ]);
        \Mail::send('forget', ['token' => $token], function($message) use($request)
        {
              $message->to($request->email);
              $message->subject('Reset Password');
        });
        return response()->json(['code_status'=>200,'message'=>'We have e-mail your password reset link!']);
    }
    public function showResetPassword($token) { 
        return view('forgetPasswordLink', ['token' => $token]);
      }
    public function submitResetPassword(Request $request)
      {
        //dd($request);
        $request->validate([
              'password' => 'required',
          ]);
        $update = \DB::table('password_resets')
          ->where([
            'email' => $request->email, 
            'token' => $request->token,
        ])
        ->first();
        //dd($update);
        if(!$update){
        return response()->json(['message'=>'Invalid token!']);
        //dd('no');
        }else{
        $user = User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);
        \DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return response()->json(['code_status'=>200,'message'=>'Your password has been changed!']);
          }
      }
}
