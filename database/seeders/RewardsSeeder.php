<?php

namespace Database\Seeders;

use App\Models\Rewards;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rewardsData = [
            [
                'type' => 'votePoints',
                'value' => 10,
            ],
            [
                'type' => 'CommentPoints',
                'value' => 2,
            ],
            [
                'type' => 'FollowPoints',
                'value' => 30,
            ],
            [
                'type' => 'VisitSitePoints',
                'value' => 100,
            ],
            [
                'type' => 'DailyRewards',
                'value' => 20,
            ],
            [
                'type' => 'AddPostPoints',
                'value' => 5,
            ],
            [
                'type' => 'GetupvotePoints',
                'value' => 15,
            ],
            [
                'type' => 'GetdownvotePoints',
                'value' => -15,
            ],
            [
                'type' => 'PostVisitPoints',
                'value' => 100,
            ],
            [
                'type' => 'RestaurantVisitPoints',
                'value' => 150,
            ],
            [
                'type' => 'FollowerRestaurantPoints',
                'value' => 10,
            ],
        ];

        foreach ($rewardsData as $data) {
            Rewards::create([
                'type' => $data['type'],
                'value' => $data['value'],
            ]);
        }
    }
}
