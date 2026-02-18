<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\LoginAttemptService;

class AuthController extends Controller
{
    private LoginAttemptService $loginAttemptService;

    public function __construct(LoginAttemptService $loginAttemptService)
    {
        $this->loginAttemptService = $loginAttemptService;
    }

    public function showLanding()
    {
        if (session()->has('authenticated_user')) {
            $user = session('authenticated_user');
            if ($user === 'yasmine') {
                return redirect()->route('presentation');
            }
            return redirect()->route('dashboard');
        }
        return view('landing');
    }

    public function showBestPerson()
    {
        if (session()->get('authenticated_user') !== 'yasmine') {
            return redirect()->route('landing');
        }
        return view('best-person');
    }

    public function verifyName(Request $request)
    {
        $key = 'verify-name:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['error' => 'Too many attempts. Please try again later.'], 429);
        }

        RateLimiter::hit($key, 60);

        $name = strtolower(trim($request->input('name')));
        $validNames = ['amine', 'yasmine'];

        if (!in_array($name, $validNames)) {
            $this->loginAttemptService->logAttempt($request, $name, null, false);
            return response()->json(['valid' => false]);
        }

        session(['verified_name' => $name]);
        return response()->json(['valid' => true, 'name' => $name]);
    }

    public function verifyEmail(Request $request)
    {
        $key = 'verify-email:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['error' => 'Too many attempts. Please try again later.'], 429);
        }

        RateLimiter::hit($key, 60);

        $name = session('verified_name');
        $email = strtolower(trim($request->input('email')));

        $validEmails = [
            'amine' => 'fathallahamine2004@gmail.com',
            'yasmine' => 'benharizyasmin@gmail.com',
        ];

        $success = isset($validEmails[$name]) && $validEmails[$name] === $email;

        $this->loginAttemptService->logAttempt($request, $name, $email, $success);

        if ($success) {
            session(['verified_email' => $email, 'authenticated_user' => $name]);
            
            if ($name === 'yasmine') {
                return response()->json(['valid' => true, 'needs_best_person' => true]);
            }
            
            return response()->json(['valid' => true, 'needs_best_person' => false]);
        }

        return response()->json(['valid' => false]);
    }

    public function verifyBestPerson(Request $request)
    {
        $name = session('authenticated_user');
        
        if ($name !== 'yasmine') {
            return response()->json(['valid' => false], 403);
        }

        $answer = strtolower(trim($request->input('answer')));

        if ($answer === 'you') {
            return response()->json(['valid' => true, 'granted' => true]);
        }

        if ($answer === 'amine') {
            return response()->json(['valid' => true, 'granted' => true, 'playful' => true]);
        }

        return response()->json(['valid' => false, 'granted' => false]);
    }
}
