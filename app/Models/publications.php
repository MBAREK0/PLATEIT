<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class publications extends Model
{
    use HasFactory;

    protected $fillable = [
        "plate_name",
        "restaurant_Name",
        "image",
        "description",
        "restaurant_link",
        "user_id",


    ] ;
}
