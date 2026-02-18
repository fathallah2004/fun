<?php

namespace App\Services;

use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginAttemptNotification;

class LoginAttemptService
{
    public function logAttempt(Request $request, string $enteredName, ?string $enteredEmail, bool $success): void
    {
        $browser = $this->getBrowser($request->userAgent());
        $deviceInfo = $this->getDeviceInfo($request->userAgent());

        $attempt = LoginAttempt::create([
            'entered_name' => $enteredName,
            'entered_email' => $enteredEmail,
            'ip_address' => $request->ip(),
            'browser' => $browser,
            'device_info' => $deviceInfo,
            'user_agent' => $request->userAgent(),
            'success' => $success,
        ]);

        Mail::to('fathallahamine2004@gmail.com')->queue(new LoginAttemptNotification($attempt));
    }

    private function getBrowser(?string $userAgent): string
    {
        if (!$userAgent) return 'Unknown';

        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'Opera') !== false) return 'Opera';

        return 'Unknown';
    }

    private function getDeviceInfo(?string $userAgent): string
    {
        if (!$userAgent) return 'Unknown';

        $device = 'Desktop';
        if (preg_match('/mobile|android|iphone|ipad/i', $userAgent)) {
            $device = 'Mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            $device = 'Tablet';
        }

        return $device;
    }
}
