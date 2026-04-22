<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
{
    try {
        Log::info('=== CALLBACK START ===');
        
        $googleUser = Socialite::driver('google')->user();
        Log::info('Google user: ' . $googleUser->getEmail());
        
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(uniqid()),
                'role' => 'employee',
            ]
        );
        Log::info('User created/found: ' . $user->id);
        
        Auth::login($user);
        Log::info('After Auth::login, Auth::check(): ' . (Auth::check() ? 'true' : 'false'));
        
        session()->save();
        Log::info('Session saved, ID: ' . session()->getId());
        
        return redirect('/dashboard');
        
    } catch (\Exception $e) {
        Log::error('Error: ' . $e->getMessage());
        return redirect('/login')->with('error', $e->getMessage());
    }
}
}