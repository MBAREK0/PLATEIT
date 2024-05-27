<?php

namespace App\Customs\Services;

use App\Jobs\ResetPasswordJob;
use App\Models\EmailVerificationToken;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
class EmailVerificationService
{

    /**
     * Send Verification link to user
     */

     public function sendVerificationLink($user){
        Notification::send($user, new EmailVerificationNotification($this->generateVerificationLink($user->email)));
     }

     /**
      * Resend erification link to user
      */
      public function resendLink($email){
        $user = User::where("email", $email)->first();
        if($user){
            $this->checkIfEmailVerified($user);
            $this->sendVerificationLink($user);
            return response()->json([
                'status'=> 'success',
                'message'=> 'Verification Link Sent successfully'
            ]);
        } else{
            return response()->json([
                'status' => 'failed',
                'error' => 'User not found '
            ]);
        }
      }

     /**
      *  Check if user already been verified
      */
      public function checkIfEmailVerified($user){
         if($user->email_verified_at){
            response()->json([
                'status' => 'failed',
                'message'=> 'Email Has Already Been Verified'
            ])->send();
            exit;
         }
      }
      /**
       * Verify the user email
       */

       public function verifyEmail(string $email ,string $token){
        $user = User::where('email', $email)->first();
        if(!$user){
            response()->json([
                'status' => 'failed',
                'error'=> 'User Not Found '
               ])->send();
               exit;
        }
        $this->checkIfEmailVerified($user);
        $verifyToken = $this->VerifyToken($email, $token);
        if($user->markEmailAsVerified()){
            $verifyToken->delete();
            return response()->json([
                'status'=> 'success',
                'message'=> 'Email has been verified successfully'
            ]);
        }else{
            return response()->json([
                'status' => 'failed',
                'error'=> 'Email verification failed, please try again later'
               ]);
        }
       }

     /**
      * Verify Token
      */
      public function  VerifyToken(string $email, string $token){
        $token = EmailVerificationToken::where("email", $email)
                                       ->where('token',$token)->first();
        if($token){
            if($token->expired_at >= now()){
                 return $token;
            } else{
                $token->delete();
                response()->json([
                    'status' => 'failed',
                    'error'=> 'Token Is Expired '
                   ])->send();
                   exit;
            }
        }else{
           response()->json([
            'status' => 'failed',
            'error'=> 'Invalid token'
           ])->send();
           exit;
        }
      }
    /**
     * Generate Verification link
     */

     public function generateVerificationLink($email)
     {
        $checkIfTokenExists = EmailVerificationToken::where('email',$email)
                                                    ->first();
         if ($checkIfTokenExists)$checkIfTokenExists->delete();

         $token = Str::uuid();
         $url = config('app.url'). "?token=" . $token . "&email=" . $email ;
         $saveToken = EmailVerificationToken::create([
            "email"=> $email,
            "token"=> $token,
            "expired_at"=> now()->addMinutes(60)
         ]);
         if($saveToken) return $url;

     }

     /**
      * forget Password
      */

      public function forgetPassword(string $email){
        $data['email'] =  $email;
        $data['subject'] = 'reset your password';
        $data['view'] = 'mail.ResetPassword';
        $data['content'] = '' ;
        dispatch(new ResetPasswordJob($data));

        $token = Hash::make(Str::random(60));

        $user =User::where('email',$email)->first();

        if ($user) {
            $userId = $user->id;
            User::where('id', $userId)->update(['remember_token' => $token]);
            return response()->json([
                'status'=> 'success',
                'message'=> 'email sent successfully',
                'reset_token' => $token
            ]);

        }
            return response()->json([
                'status'=> 'faild',
                'error'=> 'User Not Found'
            ]);
      }
            /**
       * Reset Password
       */
      public function resetPassword($password,$reset_token){
        $user = User::where('remember_token', request('reset_token'))->first();
        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
            return response()->json([
                'status'=> 'success',
                'message' => 'Password updated successfully'
            ]);
        }
        return response()->json([
            'status'=> 'failed',
            'error'=> 'User Not Found, Please try again later'
        ]);
      }

}
