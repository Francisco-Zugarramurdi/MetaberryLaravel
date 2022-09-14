<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdTag extends Model
{
    use HasFactory;
    protected $table = "ad_tags";

    public function ad() {
        return $this->belongsTo(Ad::class, 'ad_id', 'id');
    }
}
