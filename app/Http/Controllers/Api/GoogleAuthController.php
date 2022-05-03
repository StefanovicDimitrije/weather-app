<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // Sends our user to the Google page for him to login into his Google account
    public function redirectToProvider()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

        return response()->json([
           'url' => $url
        ]);
    }

    // Accepts the return statement from Google, when the user logged into his account
    public function handleProviderCallback()
    {
        $userGoogle = Socialite::driver('google')->stateless()->user();

        // In case the registration failed, and we didn't get the token
        if(!$userGoogle->token){
            return response()->json([
               'Error'=>'Registration failed: No token'
            ]);
        }

        // If there is a user under the email of the use logged in, get, else create new entry
        $sqlUser = User::firstOrCreate([
            'email' => $userGoogle->email
        ],[
            'name' => $userGoogle->name,
            'password' => Hash::make(Str::random(24)),
            'google_user_id' => $userGoogle->id,
            'chosen_city' => 'Maribor'
        ]);

        Auth::login($sqlUser);

        $user = Auth::user();
        $token = $user->createToken('google_token');

        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $userGoogle
        ]);

    }

}
