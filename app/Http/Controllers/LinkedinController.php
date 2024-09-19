<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LinkedinController extends Controller
{
    public function redirectToLinkedin(){
        return Socialite::driver('linkedin')->redirect('');

    }

    public function handleLinkedinCallback(){
        try {
            $user = Socialite::driver('linkedin')->user();
            $findUser = User::where('linkedin_id', $user->id)->first();

            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            }else{
                $newUser = User::updateOrCreate([
                    'email' => $user->email,
                    'name' => $user->name,
                    'linkedin_id' => $user->id,
                    'password' => encrypt('12345dummy'),
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
