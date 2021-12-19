<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $fillable = ['short_link_id','name'];
    public function shortLink()
    {
        return $this->belongsTo(ShortLink::class);
    }
}
