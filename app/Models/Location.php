<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description'];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function getHashedAttribute():string {
        $seed = $this->code . $this->id;
        $hashed = hash('ripemd160', $seed);

        return $hashed;
    }

    public function getUrlAttribute():string {
        $url = url('checkin/' . $this->organization->code . '/' . $this->hashed);

        return $url;
    }
}
