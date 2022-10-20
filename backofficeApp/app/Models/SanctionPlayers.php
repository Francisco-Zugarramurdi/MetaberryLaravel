<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanctionPlayers extends Model
{
    use HasFactory;
    protected $table = "sanction_players";

    protected $fillable = [
        'id_sancion',
        'id_players'
    ];
}
