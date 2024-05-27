<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendForgetPasswordToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResetPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
     protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {

        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    Log::info('ResetPasswordJob handling...');
    $info = $this->data;
    $email = new SendForgetPasswordToken($info);
    Mail::to($this->data['email'])->send($email);
    Log::info('ResetPasswordJob handled successfully.');
    }
}
