<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtraCompose extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "extra_compose";
    protected $fillable = [
        'id_extra',
        'id_teams',
        'contract_start',
        'contract_end'
    ];
}
