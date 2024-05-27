<?php

namespace App\Http\Controllers\Api;

use App\Customs\Services\JwtTokenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SystemOfPointsJob;
use App\Models\PointsOfVisits;
use Illuminate\Support\Facades\Validator;


class PointsOfVisitsController extends Controller
{
    protected $__post_id;
    protected $__restaurant_id;
    protected $__user_id;

    private $JwtService;
    public function __construct(){
        $this->JwtService = new JwtTokenService;
    }

    public function  index(Request $request){

        $validator = Validator::make($request->all(), [
			'restaurant_id' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => 'failed', 'error' => $validator->errors() ]);
		}
            $postId =$request->publication_id;
            if(empty($request->publication_id)){
                $postId = '';
            }

            $token = request()->header('Authorization');
            $user = $this->JwtService->get_user($token)->id;
            $this->__post_id = $postId;
            $this->__restaurant_id = $request->restaurant_id;
            $this->__user_id = $user;
            return $this->check();

    }
    public function give_restaurant_points(): void
    {
        dispatch(new SystemOfPointsJob($this->__restaurant_id,'RestaurantVisitPoints'))->add_points();

    }
    public function give_author_points(): void
    {
        dispatch(new SystemOfPointsJob(null,'PostVisitPoints'))->get_author_id('publications',$this->__post_id)->add_points();

    }
    public function give_user_points(): void
    {
        dispatch(new SystemOfPointsJob($this->__user_id,'VisitSitePoints'))->add_points();

    }
    public function check(){

        $check =  PointsOfVisits::where('user_id',$this->__user_id)
        ->where('restaurant_id',$this->__restaurant_id)
        ->where('publication_id',$this->__post_id)
        ->count();
        if($check > 0){
            return response()->json([
                "status" => "failed",
                "message" => "you have already get the points for visit this restaurant"
            ]);
        }
        $this->give_author_points();
        $this->give_restaurant_points();
        $this->give_user_points();

       $PointsOfVisits= PointsOfVisits::create([
            'user_id' =>$this->__user_id,
            'restaurant_id'=>$this->__restaurant_id,
            'publication_id'=>$this->__post_id
        ]);
        if( $PointsOfVisits){
            return response()->json([
                'status'=> 'success',
                'message'=> 'Points Added Successfully'
            ]);
        }

    }



}
