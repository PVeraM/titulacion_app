<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];


    public function stores()
    {
        return $this->belongsToMany(Store::class, 'service_store');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
