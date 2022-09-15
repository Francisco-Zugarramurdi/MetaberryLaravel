<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class users_data extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "users_data";
    protected $fillable = [ 'name','credit_card','photo','points','type_of_user','total_points'];
}
