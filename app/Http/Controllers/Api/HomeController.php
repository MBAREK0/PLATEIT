<?php

namespace App\Http\Controllers\Api;

use App\Customs\Services\JwtTokenService;
use App\Models\publications;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $JwtService;
    public function __construct(){
        $this->JwtService = new JwtTokenService;
    }

    public function index(){
        $key = request("key");
        $type = request("type") ?? 'all';
        // return response()->json([
        //     'key' => $key,
        //     'type'=> $type
        // ]);
        if($type == 'all'){
            $publications =  DB::table('publications as P')
            ->join('users as U', 'P.user_id', '=', 'U.id')
            ->where('U.fullName', 'like', '%' . $key . '%')
            ->orWhere('P.plate_name', 'like', '%' . $key . '%')
            ->orWhere('P.restaurant_Name', 'like', '%' . $key . '%')
            ->select('P.*', 'U.fullName as author', 'U.Points as author_points', 'U.id as author_id')
            ->get();

        } else if($type == 'restaurant'){
            $publications = DB::table('publications as P')
            ->join('users as U', 'P.user_id', '=', 'U.id')
            ->where('U.role', 'restaurant')
            ->where(function ($query) use ($key) {
                $query->where('U.fullName', 'like', '%' . $key . '%')
                      ->orWhere('P.plate_name', 'like', '%' . $key . '%')
                      ->orWhere('P.restaurant_Name', 'like', '%' . $key . '%');
            })
            ->select('P.*', 'U.fullName as author', 'U.Points as author_points', 'U.id as author_id')
            ->get();

        }else if($type == 'follow'){
            $token = request()->header('Authorization');
            $user = (int) $this->JwtService->get_user($token)->id;

            $query = "
            SELECT P.*, U.fullName AS author, U.Points AS author_points, U.id AS author_id
            FROM publications AS P
            INNER JOIN users AS U ON P.user_id = U.id
            INNER JOIN follows AS F ON F.user_id = ?
            WHERE U.role = 'restaurant'
            AND (U.fullName LIKE '%%'
                 OR P.plate_name LIKE '%%'
                 OR P.restaurant_Name LIKE '%%')
        ";

        $publications = DB::select($query, [$user]);
        }


        if (empty($publications)){
            return response()->json([
                'status' => 'failed',
                'message'=> 'NO Result Found'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data'=> $publications
        ]);
        }
    }

