<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gifts extends Model
{
    use HasFactory;
    protected $fillable = [
        "image",
        "points_cost",
        "description",
        "name",
    ];
    protected $table = "gifts";
}
