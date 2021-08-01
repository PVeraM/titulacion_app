<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'description',
        'ranking',
        'service_id',
        'enterprise_id',
        'store_id',
        'user_id',
    ];

    protected $hidden = [
        'deleted_at',
        'description_enable'
    ];

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
