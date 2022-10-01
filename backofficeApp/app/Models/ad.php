<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "ads";
    protected $fillable = [ 'image','size', 'url', 'views_hired', 'view_counter'];

}
