<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboration_restaurants extends Model
{
    use HasFactory;
    protected $fillable = [
        "type_id",
        "restaurant_id",
    ];
}
