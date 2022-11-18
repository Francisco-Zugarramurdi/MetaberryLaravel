<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    protected $table = "users_data";
    protected $fillable = ['name','credit_card','photo','points','type_of_user','total_points'];

}
