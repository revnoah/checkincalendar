<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // protected $with = ['organization'];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }    
}
