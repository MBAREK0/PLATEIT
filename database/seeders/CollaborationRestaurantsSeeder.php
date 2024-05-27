<?php

namespace Database\Seeders;

use App\Models\Collaboration_restaurants;
use App\Models\collaboration_types;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CollaborationRestaurantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

$faker = Faker::create();

for ($i = 0; $i < 5; $i++) {

    DB::table('users')->insert([
        'fullName' => $faker->word . ' ' . $faker->city . ' Restaurant',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => $faker->dateTime,
        'password' => bcrypt('password'),
        'Points' => $faker->randomDigit,
        'ProfileImage' => $faker->imageUrl,
        'bio' => $faker->text,
        'role' => 'restaurant',

    ]);

   
}
    }
}
