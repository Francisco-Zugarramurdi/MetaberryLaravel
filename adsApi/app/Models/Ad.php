<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $table = "ads";

    public function adTag()
    {
        return $this->hasMany(AdTags::class, 'ad_id', 'id');
    }
}
