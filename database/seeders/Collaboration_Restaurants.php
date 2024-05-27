<?php

namespace Database\Seeders;

use App\Models\Collaboration_restaurants as ModelsCollaboration_restaurants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Collaboration_Restaurants extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for( $j = 1; $j <= 5; $j++) {
            ModelsCollaboration_restaurants::create([
                'type_id'=>$j,
                'restaurant_id'=>$j,
            ]);
        }
    }
}
