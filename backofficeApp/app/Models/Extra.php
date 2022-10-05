<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extra extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "extras";
    protected $fillable = [
        'name',
        'surname',
        'photo',
        'rol',
    ];
}
