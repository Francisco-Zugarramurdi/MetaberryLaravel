<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Player extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "players";
    protected $fillable = [
        'name',
        'surname',
        'photo',
    ];
}
