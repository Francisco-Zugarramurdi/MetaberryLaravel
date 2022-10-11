<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdTag extends Model
{
    use HasFactory;
    protected $table = "ad_tags";
    protected $fillable = ['id_tag','id_ad'];
}