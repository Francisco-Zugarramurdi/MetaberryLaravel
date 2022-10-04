<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "countries";
    protected $fillable = [ 'name','photo'];
}
