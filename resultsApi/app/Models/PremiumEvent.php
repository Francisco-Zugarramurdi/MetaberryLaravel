<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumEvent extends Model
{
    use HasFactory;
    protected $table = "premium_events";
    protected $fillable = ['id_users_data','id_events'];

}