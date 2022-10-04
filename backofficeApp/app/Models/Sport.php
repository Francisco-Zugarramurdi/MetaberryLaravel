<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sports";
    protected $fillable = [ 'name','photo'];
}
