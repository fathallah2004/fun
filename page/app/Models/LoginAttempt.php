<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = [
        'entered_name',
        'entered_email',
        'ip_address',
        'browser',
        'device_info',
        'user_agent',
        'success',
    ];

    protected $casts = [
        'success' => 'boolean',
        'created_at' => 'datetime',
    ];
}
