<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use HasFactory, softDeletes;
    protected $table = "users_subscriptions";
    protected $fillable = [ 'id_users', 'type_of_subscription'];
}

