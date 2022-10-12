<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultPoint extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "results_points";
    protected $fillable = [
        'id_results',
        'id_teams',
        'id_players',
        'point'

    ];
}