<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsOfVisits extends Model
{
    use HasFactory;
    protected $fillable = [
        "restaurant_id",
        "user_id",
        "publication_id"
        ];
    protected $table = "points_of_visits";
}
