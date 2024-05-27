<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantDetailsRequest;
use App\Models\Category;
use App\Models\Restaurant_details;
use App\Models\User;

class RestaurantDetailsController extends Controller
{

    public function insert_details(RestaurantDetailsRequest  $Request){

        $category_id =  $Request->category_id;
        if( !$category_id){
            $category_id = 1;
        }

        Restaurant_details::updateOrCreate(['restaurant_id' => $Request->restaurant_id], [
            'category_id' => $category_id,
            'address'=> $Request->address,
            'phone_numbre'=> $Request->phone_numbre,
            'web_site'=> $Request->web_site,
        ]);

        $user = User::find($Request->restaurant_id);
        $user->ProfileImage = $Request->ProfileImage;
        $user->bio = $Request->bio;
        $user->save();
        return response()->json([
            'status'=> 'success',
            'message'=> 'Details Updated Successfully',

        ],200);

    }
        public function get_details(Request $Request){

           $restaurant_id = $Request->restaurant_id;
           $restaurant_details = Restaurant_details::where('restaurant_id', $restaurant_id)->first();
           if( !$restaurant_details ){
            return response()->json([
                'status'=> 'failed',
                'error' => 'Details Not Found',
                'restaurant_id'=>$restaurant_id
            ],401);
           }
           $category_id = $restaurant_details->category_id;
           $category = Category::find( $category_id )->name;
           $restaurant_details->category = $category;

           $restaurant = User::find($restaurant_id);

           return response()->json([
            'status'=> 'success',
            'message'=> 'Details Selected Successfully',
            'restaurant'=> $restaurant,
            'restaurant_details'=>$restaurant_details
           ],200);
        }
}
