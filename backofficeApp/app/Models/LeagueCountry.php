<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueCountry extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "leagues_countries";
    protected $fillable = [
        'id_countries',
        'id_leagues'
    ];

}
