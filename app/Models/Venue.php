<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'espn_id',
        'name',
        'city',
        'state',
        'capacity',
        'dome',
        'surface_type'
    ];
}
