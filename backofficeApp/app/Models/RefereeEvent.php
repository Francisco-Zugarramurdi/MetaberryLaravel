<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefereeEvent extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "referee_events";
    protected $fillable = [
        'id_referee',
        'id_events',
        'dates',
        'deleted_at'
    ];
    
}