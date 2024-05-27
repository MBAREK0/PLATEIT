<?php

namespace Database\Seeders;

use App\Models\collaboration_types;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollaborationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $collaborations = [
            'Promotional Collaborations',
            'Content Collaborations',
            'Online Ordering and Delivery',
            'Events and Collaborative Projects',
            'Community Engagement',
        ];

        foreach ($collaborations as $collaboration) {
           collaboration_types::create([
            'type'=> $collaboration,
           ]);
        }
    }
}
