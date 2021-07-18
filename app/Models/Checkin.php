<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'location_id', 'username', 'ip_address'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
