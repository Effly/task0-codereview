<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;
    protected $fillable = ['long_url','title','code'];

    public function tags()
    {
        return $this->hasMany(Tags::class);
    }
    public function viewers()
    {
        return $this->hasMany(Viewers::class);
    }
}
