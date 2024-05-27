<?php

namespace App\Customs\Services;

use App\Models\DailyRewards;
use App\Models\Rewards;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PointsSestemService
{
    public function add_points($user_id, $type)
    {
        $user = User::find($user_id);
        $reward = Rewards::where('type', $type)->first();

        if ($reward) {
            $rewardValue = (float) $reward->value;
            $user->Points += $rewardValue;
            $user->save();
        }
    }
    public function remove_points($user_id, $type)
    {
        $user = User::find($user_id);
        $reward = Rewards::where('type', $type)->first();

        if ($reward) {
            $rewardValue = (float) $reward->value;
            $user->Points -= $rewardValue;
            $user->save();
        }
    }
    public function get_user($model , $primery_key){

        if($model == 'users'){
            $user = User::find($primery_key);
            return $user->id;
        }
        $userId = DB::table($model)
            ->join('users', $model.'.user_id', '=', 'users.id')
            ->where($model.'.id', $primery_key)
            ->select('users.id')
            ->first();

        if ($userId) {
            $userId = $userId->id;
            return  $userId;
        }
    }
    public function visit_our_app_points($user_id){

        $count =  DailyRewards::where('user_id', $user_id)->count();
        $reward = Rewards::where('type','DailyRewards')->first();
        $rewardValue = (float) $reward->value;
        if ($count > 0) {

            $this->visit_our_app_points_get($user_id);

        }else{
            $points= $rewardValue;
            DailyRewards::create([
                'user_id'=> $user_id,
                'DailyRewards'=> $points,
            ]);
            $this->add_points($user_id,'DailyRewards');
        }
    }

    public function visit_our_app_points_get($user_id){

        $last_reward = DailyRewards::where('user_id', $user_id)
        ->latest('created_at')
        ->select('created_at', 'DailyRewards')
        ->first();

    $reward = Rewards::where('type', 'DailyRewards')->first();
    $rewardValue = (float) $reward->value;

    if ($last_reward) {
        $last_created_at =strtotime($last_reward->created_at);
        $now_seconds = time();
        // $future_seconds = $now_seconds + (2* 24 * 60 * 60);
        $future_seconds = $now_seconds;
        $_24_hour_by_seconds = 24*60*60;
        $result = $future_seconds - $last_created_at;


        // Check if the last visit is between 24 and 48 hours ago
        if ($result >= $_24_hour_by_seconds && $result < (2 * $_24_hour_by_seconds)) {
            $points = $last_reward->DailyRewards + $rewardValue;
            if( $points > 7 * $rewardValue ){
                $points = $rewardValue;
            }
        }
        // Check if the last visit is more than 48 hours ago
        elseif ($result >= (2 * $_24_hour_by_seconds)) {
            $points = $rewardValue;
        }
        else{
            return 0;
        }

        DailyRewards::create([
            'user_id' => $user_id,
            'DailyRewards' => $points,
        ]);
        $this->add_daily_points($user_id, $points);
    } else {
        return response()->json([
            'error' => 'Something went wrong when getting the last reward',
        ]);
    }
    }
    public function add_daily_points($user_id, $points)
    {
        $user = User::find($user_id);
        $user->Points += $points;
        $user->save();
    }
}
