<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\AdminResetPassowrdNotification;

class AdminUser extends User
{
    protected $table = "admin_users";

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassowrdNotification($token));
    }
}
