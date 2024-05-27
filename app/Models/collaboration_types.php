<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collaboration_types extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
    ];
    protected $table = "collaboration_types";
}
