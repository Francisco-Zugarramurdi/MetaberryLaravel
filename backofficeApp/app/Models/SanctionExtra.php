<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanctionExtra extends Model
{
    use HasFactory;
    protected $table = 'sanctions_extra';
    protected $fillable = [
        'id_sancion',
        'id_extra',
        'minute'
    ];
}
