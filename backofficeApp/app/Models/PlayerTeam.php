<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerTeam extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "players";
    protected $fillable = [
        'id_players',
        'id_players',
        'contract_start'
    ];
}

