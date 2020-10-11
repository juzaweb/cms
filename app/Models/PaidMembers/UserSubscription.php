<?php

namespace App\Models\PaidMembers;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'user_subscriptions';
    protected $fillable = [
        'token',
        'role',
        'method',
        'agreement_id',
        'payer_id',
        'payer_email',
        'amount',
        'user_id',
    ];
}
