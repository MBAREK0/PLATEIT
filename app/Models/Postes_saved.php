<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postes_saved extends Model
{
    use HasFactory;
    protected $fillable = [
		'publication_id',
        'user_id',
	];
    protected $table = 'postes_saved';
}
