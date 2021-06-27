<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;



    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_store');
    }
}
