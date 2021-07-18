<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'fieldtype', 'value'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
