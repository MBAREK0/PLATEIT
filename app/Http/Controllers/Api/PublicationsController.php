<?php

namespace App\Http\Controllers\Api;

use App\Customs\Services\JwtTokenService;
use App\Models\publications;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Jobs\SystemOfPointsJob;

class PublicationsController extends Controller
{


    private $JwtService;

    public function __construct(){
        $this->JwtService = new JwtTokenService;

    }

	public function save_post(PostRequest $request){

        $token = $request->header('Authorization');
        $user = $this->JwtService->get_user($token);

			if(!empty($request->id)){
				$Post = publications::where('id', $request->id)->update([
					'plate_name' => $request->plate_name,
					'restaurant_Name' => $request->get('restaurant_Name'),
					'image' => $request->get('image'),
					'description' => $request->get('description'),
					'restaurant_link' => $request->get('restaurant_link'),
                    'user_id' => $user->id,
				]);
				if($Post){
					return response()->json(['status' => 'success', 'message' => 'Post updated successfully!']);
				} else{
                    return response()->json(['status' => 'faild', 'error' => 'error when updated the Post ']);
                }
			}else{

				$Post = publications::create([
					'plate_name' => $request->plate_name,
					'restaurant_Name' => $request->get('restaurant_Name'),
					'image' => $request->get('image'),
					'description' => $request->get('description'),
					'restaurant_link' => $request->get('restaurant_link'),
                    'user_id' => $user->id,
				]);
				if($Post){
                    dispatch(new SystemOfPointsJob($user->id,'AddPostPoints'))->add_points();
                    return response()->json(['status' => 'success', 'message' => 'Post saved successfully!']);
				}else{
                    return response()->json(['status' => 'faild', 'error' => 'error when saved the Post ']);
                }
			}
		}



	public function delete( $PostID = '')
    {
        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token);
        $id = request()->get('id');
        if($PostID){
            $id= $PostID;
        }
		$Post = publications::findOrFail($id);
		if($Post->delete()){
            dispatch(new SystemOfPointsJob($user->id,'AddPostPoints'))->remove_points();

			return response()->json(['status' => 'success', 'message' => 'Post deleted successfully!' ]);
		}
	}




}
