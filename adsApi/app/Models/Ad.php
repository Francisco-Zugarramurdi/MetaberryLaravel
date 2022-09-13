<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdTag;


class ad extends Model
{
    use HasFactory;
    protected $table = "ads";

    public function adTag()
    {
        return $this->hasMany(AdTags::class, 'ad_id', 'id');
    }
}
