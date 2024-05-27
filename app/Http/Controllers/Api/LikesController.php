<?php

namespace App\Http\Controllers\Api;

use App\Models\likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Customs\Services\JwtTokenService;
use App\Jobs\SystemOfPointsJob;

class LikesController extends Controller
{

    private $JwtService;
    public function __construct(){
        $this->JwtService = new JwtTokenService;
    }

	public function save_like(Request $request){

        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token)->id;

		$validator = Validator::make($request->all(), [
			'publication_id' => 'required',
			'type' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => 'failed', 'error' => $validator->errors() ]);
		}else{
			if(!empty($request->id)){
                $check = Likes::where('user_id', $user)
                ->where('publication_id',$request->get('publication_id'))
                ->where('type', $request->get('type'));


                if($check->count() > 0){
                return response()->json(['status'=> 'failed', 'error' => "You can't modified the like type using the same type " ]);
                }
				$likes = Likes::where('id', $request->id)->update([
					'publication_id' => $request->get('publication_id'),
					'type' => $request->get('type'),
                    'user_id'=> $user,
				]);
				if($likes){
                    dispatch(new SystemOfPointsJob(null,'Get'.$request->get('type').'votePoints'))->get_author_id('publications',$request->get('publication_id'))->add_points();
                    dispatch(new SystemOfPointsJob(null,'Get'.$request->get('type').'votePoints'))->get_author_id('publications',$request->get('publication_id'))->add_points();
					return response()->json(['status' => 'success', 'message' => 'likes updated successfully!']);
				}
			}else{
                $check = Likes::where('user_id', $user)
                                ->where('publication_id',$request->get('publication_id'));


                if($check->count() > 0){
                 return response()->json(['status'=> 'failed', 'error' => 'Like already exist' ]);
                }
				$likes = Likes::create([
					'publication_id' => $request->get('publication_id'),
					'type' => $request->get('type'),
                    'user_id'=> $user,
				]);
				if($likes){
                    dispatch(new SystemOfPointsJob($user,'votePoints'))->add_points();
                    dispatch(new SystemOfPointsJob(null,'Get'.$request->get('type').'votePoints'))->get_author_id('publications',$request->get('publication_id'))->add_points();
					return response()->json(['status' => 'success', 'message' => 'likes saved successfully!']);
				}
			}
		}
	}

	public function delete(){
        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token)->id;
        $id = request('id') ;

		$like = Likes::findOrFail($id);

		if($like->delete()){
        dispatch(new SystemOfPointsJob($user,'votePoints'))->remove_points();
			return response()->json(['status' => 'success', 'message' => 'like deleted successfully!' ]);
		}
	}
}
