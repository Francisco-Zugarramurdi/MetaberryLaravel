<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueEvent extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "leagues_events";
    protected $fillable = [
        'id_events',
        'id_leagues'
    ];

}
