<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viewers extends Model
{
    use HasFactory;
    protected $fillable = ['user_agent','ip'];
    public function shortLink()
    {
        return $this->belongsTo(ShortLink::class);
    }
}
