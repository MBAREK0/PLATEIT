<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Postes_saved;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Customs\Services\JwtTokenService;
use Illuminate\Support\Facades\DB;


class PostesSavedController extends Controller
{
    private $JwtService;
    public function __construct(){
        $this->JwtService = new JwtTokenService;
    }
    public function saved_post(Request $request){

        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token)->id;

		$validator = Validator::make($request->all(), [
			'publication_id' => 'required',

		]);

		if($validator->fails()){
			return response()->json(['status' => 'failed', 'error' => $validator->errors() ]);
		}else{
            $check = Postes_saved::where('user_id', $user)->where('publication_id',$request->get('publication_id'));
            if($check->count() > 0){
             return response()->json(['status'=> 'failed', 'error' => 'post already saved' ]);
            }

				$Postes_saved = Postes_saved::create([
					'publication_id' => $request->get('publication_id'),
                    'user_id'=> $user,

				]);
				if($Postes_saved){
					return response()->json(['status' => 'success', 'message' => 'Postes saved successfully!']);
				}
			}
		}
        public function delete(){
            $id = request('id') ;
            $Postes_saved = Postes_saved::findOrFail($id);
            if($Postes_saved->delete()){
                return response()->json(['status' => 'success', 'message' => 'Postes_saved deleted successfully!' ]);
            }
        }


	}


