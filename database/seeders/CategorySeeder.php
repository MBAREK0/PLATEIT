<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurantCategories = [
            'Restaurant',
            'Italian Restaurants',
            'Mexican Restaurants',
            'Chinese Restaurants',
            'Indian Restaurants',
            'French Restaurants',
            'Japanese Restaurants',
            'Thai Restaurants',
            'Mediterranean Restaurants',
            'American Restaurants',
            'Greek Restaurants',
            'Brazilian Restaurants',
            'Korean Restaurants',
            'Spanish Restaurants',
            'Fusion Cuisine Restaurants',
            'Fine Dining Restaurants',
            'Casual Dining Restaurants',
            'Fast-Casual Restaurants',
            'Fast Food Restaurants',
            'Buffet Restaurants',
            'Food Trucks or Food Carts',
            'Pop-up Restaurants',
            'Cafe or Coffee Shops',
            'Barbecue Restaurants',
            'Seafood Restaurants',
            'Steakhouse or Grill Restaurants',
            'Vegetarian Restaurants',
            'Vegan Restaurants',
            'Gluten-Free Restaurants',
            'Pizzerias',
            'Sushi Bars or Japanese Sushi Restaurants',
            'Tapas Restaurants',
            'Food Courts',
            'Ice Cream Parlors or Gelaterias',
            'Rooftop Restaurants',
            'Waterfront or Beachfront Restaurants',
            'Family-Friendly Restaurants',
            'Romantic Restaurants',
            'Sports Bars or Sports-themed Restaurants',
            'Pub or Gastropub',
            'Bistro or Brasserie',
            'Farm-to-Table Restaurants',
            'Historic or Heritage Restaurants',
            'Cultural or Ethnic Restaurants',
            'Organic Restaurants',
            'Farm-to-Fork Restaurants',
            'Health-Focused Restaurants',
            'Allergen-Friendly Restaurants',
            'Low-Carb or Keto-Friendly Restaurants',
            'Raw Food Restaurants',
            'Juiceries or Smoothie Bars',
            'Nut-Free or Dairy-Free Restaurants',
        ];

        // Insert categories into the database
        foreach ($restaurantCategories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
