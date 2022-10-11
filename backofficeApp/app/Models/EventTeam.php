<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTeam extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "events_teams";
    protected $fillable = [
        'id_events',
        'id_teams'
    ];
    
}
