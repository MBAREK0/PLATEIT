<?php

namespace Database\Seeders;

use App\Models\Gifts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $giftssData = [
            [
                'name' => 'small_plate',
                'description' => 'Description for gifts 1',
                'PointsCost' => 1000,
                'image' => 'small_plate.jpg',
            ],
            [
                'name' => 'medium_plate',
                'description' => 'Description for gifts 2',
                'PointsCost' => 2000,
                'image' => 'medium_plate.jpg',
            ],
            [
                'name' => 'large_plate',
                'description' => 'Description for gifts 3',
                'PointsCost' => 5000,
                'image' => 'large_plate.jpg',
            ],
            [
                'name' => 'small_plate_vip',
                'description' => 'Description for gifts 4',
                'PointsCost' => 20000,
                'image' => 'small_plate_vip.jpg',
            ],
            [
                'name' => 'medium_plate_vip',
                'description' => 'Description for gifts 5',
                'PointsCost' => 50000,
                'image' => 'medium_plate_vip.jpg',
            ],
            [
                'name' => 'large_plate_vip',
                'description' => 'Description for gifts 5',
                'PointsCost' => 100000,
                'image' => 'large_plate_vip.jpg',
            ],
        ];

        foreach ($giftssData as $data) {
            Gifts::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'PointsCost' => $data['PointsCost'],
                'image' => $data['image'],
            ]);
        }
    }
}
