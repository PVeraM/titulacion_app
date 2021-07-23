<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'enterprise_id'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_store');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
