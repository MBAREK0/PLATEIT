<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Customs\Services\JwtTokenService;
use App\Jobs\SystemOfPointsJob;
use App\Models\Follows;

class FollowsController extends Controller
{
    private $JwtService;
    public function __construct(){
        $this->JwtService = new JwtTokenService;
    }
    public function follow(Request $request){

        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token)->id;

		$validator = Validator::make($request->all(), [
			'restaurant_id' => 'required',

		]);

		if($validator->fails()){
			return response()->json(['status' => 'failed', 'error' => $validator->errors() ]);
		}else{

               $check = Follows::where('user_id', $user)->where('restaurant_id',$request->get('restaurant_id'));
               if($check->count() > 0){
                return response()->json(['status'=> 'failed', 'error' => 'Follow already exist' ]);
               }
				$Follows = Follows::create([
					'restaurant_id' => $request->get('restaurant_id'),
                    'user_id'=> $user,

				]);
				if($Follows){
                    dispatch(new SystemOfPointsJob($user,'FollowPoints'))->add_points();
                    dispatch(new SystemOfPointsJob($request->get('restaurant_id'),'FollowerRestaurantPoints'))->add_points();
					return response()->json(['status' => 'success', 'message' => 'Follow saved successfully!']);
				}
			}
		}
        public function unfollow(){
            $token = request()->header('Authorization');
            $user = $this->JwtService->get_user($token)->id;
            $restaurant_id = request('restaurant_id') ;

            $Follows = Follows::where('user_id', $user)->where('restaurant_id',$restaurant_id);
            if($Follows->delete()){
                dispatch(new SystemOfPointsJob($user,'FollowPoints'))->remove_points();
                dispatch(new SystemOfPointsJob($restaurant_id,'FollowerRestaurantPoints'))->remove_points();
                return response()->json(['status' => 'success', 'message' => 'Follows deleted successfully!' ]);
            }
        }

        public function count_followers (){
            $id =  request()->get('id');
            $followers = Follows::where('restaurant_id', $id)->count();
            return response()->json(['status'=> 'success','followers'=> $followers ]);
        }
}
