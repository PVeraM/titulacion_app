<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'name'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
