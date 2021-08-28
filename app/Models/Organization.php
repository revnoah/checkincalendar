<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    // protected $with = ['locations'];

    protected $fillable = ['name', 'code', 'description'];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function settings()
    {
        return $this->hasMany(Settings::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function getHashedAttribute()
    {
        $seed = $this->code . $this->id;
        $hashed = hash('ripemd160', $seed);

        return $hashed;
    }
}
