<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{

     // Facebook login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try{
            $user = Socialite::driver('google')->user();
        }  catch(\Exception $e) {
            return redirect('/login');
     }

// dd($user);
     $existingUser = User::where('google_id',  $user->id, )->first();

     if($existingUser){
        Auth::login($existingUser, true);
     }

     else{

        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->id,
            'avatar' => $user->avatar,
            'phone' => $user->phone
            // 'password' => Hash::make(Str::random(8),)
        ]);

        Auth::login($newUser, true);
     }

     return redirect()->to('/dashboard');
  }





    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback()
    {
        try{
            $user = Socialite::driver('facebook')->user();
        }  catch(\Throwable $th) {
            return redirect('/login');
     }

// dd($user);
     $finduser = User::where('facebook_id',  $user->id, )->first();

     if($finduser){
        Auth::login($finduser, true);
     }

     else{

        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'facebook_id' => $user->id,
            'avatar' => $user->avatar,
          'facebook_avatar' => $user->facebook_avatar,
            'phone' => $user->phone
            // 'password' => Hash::make(Str::random(8),)
        ]);

        Auth::login($newUser, true);
     }

     return redirect()->to('/dashboard');
  }


}





// protected function _registerOrLoginUser($data)
//     {
//         $user = User::where('email', '=', $data->email)->first();
//         if (!$user) {
//             $user = new User();
//             $user->name = $data->name;
//             $user->email = $data->email;
//             $user->facebook_id = $data->id;
//             $user->facebook_avatar = $data->avatar;
//             $user->save();
//         }

//         Auth::login($user);
//         return redirect()->to('/dashboard');
//     }
