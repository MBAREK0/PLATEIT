<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RightSidebarController extends Controller
{
    public function trand_restaurants(){
        $key = request("key");
        $trand_restaurants = User::where('role', 'restaurant')
                                ->where('fullName', 'like', '%' . $key . '%')
                                ->orderBy('points', 'desc')
                                ->get();
        return response()->json([
            'status'=> 'success',
            'data'=> $trand_restaurants
        ]);

    }
    public function collaboration_restaurants(){
        $collaboration_restaurants = DB::table('users as R')
                    ->join('collaboration_restaurants as C', 'C.restaurant_id', '=', 'R.id')
                    ->join('collaboration_types as T', 'C.type_id', '=', 'T.id')
                    ->select('R.*', 'T.type')
                    ->get();
        return response()->json([
            'status'=> 'success',
            'data'=> $collaboration_restaurants
        ]);

    }
}
