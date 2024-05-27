<?php

namespace App\Http\Controllers\Api;

use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Customs\Services\JwtTokenService;
use App\Jobs\SystemOfPointsJob;
use Illuminate\Support\Facades\DB;
class commentsController extends Controller
{

    private $JwtService;
    public function __construct(){
        $this->JwtService = new JwtTokenService;
    }

	public function save_comment(Request $request){

        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token)->id;

		$validator = Validator::make($request->all(), [
			'publication_id' => 'required',
			'content' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => 'failed', 'error' => $validator->errors() ]);
		}else{
			if(!empty($request->id)){
				$comments = comments::where('id', $request->id)->update([
					'publication_id' => $request->get('publication_id'),
                    'user_id'=> $user,
                    'content' => $request->get('content')
				]);
				if($comments){
					return response()->json(['status' => 'success', 'message' => 'comments updated successfully!']);
				}
			}else{
				$comments = comments::create([
					'publication_id' => $request->get('publication_id'),
                    'user_id'=> $user,
                    'content' => $request->get('content')
				]);
				if($comments){
                    dispatch(new SystemOfPointsJob($user,'CommentPoints'))->add_points();
                    dispatch(new SystemOfPointsJob(null,'CommentPoints'))->get_author_id('publications',$request->get('publication_id'))->add_points();
					return response()->json(['status' => 'success', 'message' => 'comments saved successfully!']);
				}
			}
		}
	}

	public function delete(){
        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token)->id;
        $id = request('id') ;
		$comment = comments::findOrFail($id);
		if($comment->delete()){
        dispatch(new SystemOfPointsJob($user,'CommentPoints'))->remove_points();
			return response()->json(['status' => 'success', 'message' => 'comments deleted successfully!' ]);
		}
	}

    public function get_comments (){
        $post_id = request('id') ;
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.publication_id', $post_id)
            ->select('comments.content', 'users.fullName AS author', 'users.email', 'users.Points', 'users.ProfileImage', 'users.id AS author_id')
            ->orderBy('comments.created_at', 'desc') // Order by created_at column in comments table
            ->get();
            return response()->json(['status'=> 'success','comments'=> $comments]);

    }
}
