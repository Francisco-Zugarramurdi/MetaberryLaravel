<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ad_tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'ad_tags';
    protected $fillable = ['ad_id','tag'];
     
}
