<?php

namespace App\Http\Controllers\Api;

use App\Customs\Services\JwtTokenService;
use App\Customs\Services\SestemOfGiftsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class GiftsController extends Controller
{
    private $JwtService;
    private $GiftService;
    public function __construct(){
        $this->JwtService = new JwtTokenService;
        $this->GiftService = new SestemOfGiftsService;
    }
    public function index(Request $request){
        $validator = Validator::make($request->all(), [
			'gift_id' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => 'failed', 'error' => $validator->errors() ]);
		}
        $token = request()->header('Authorization');
        $user = $this->JwtService->get_user($token);

       return  $this->GiftService->index($user, $request->input('gift_id'));



    }
}
