<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Rapid\Laplus\Present\HasPresent;
use Rapid\Laplus\Present\Present;

/**
 * @Guide
 * @mixin \Rapid\_Stub\_7c4b2df66ec878ccfab0c03ed7f61989
 * @EndGuide
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPresent;

    public function present(Present $present)
    {
        $present->id();
        $present->string('name');
        $present->string('email')->unique();
        $present->timestamp('email_verified_at')->nullable();
        $present->string('password')->cast('hashed')->hidden();
        $present->rememberToken()->hidden();
        $present->timestamps();
    }
}
