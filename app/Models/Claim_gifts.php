<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim_gifts extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "gift_id",
        "random_id",
        "status",
    ];
    protected $table = "claim_gifts";
}
