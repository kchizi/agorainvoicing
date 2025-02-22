<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = ['company', 'website', 'phone', 'logo', 'address', 'host', 'port', 'encryption', 'email', 'password', 'error_log', 'error_email',
            'cart', 'subscription_over', 'subscription_going_to_end', 'forgot_password', 'order_mail', 'welcome_mail', 'invoice_template', ];
}
