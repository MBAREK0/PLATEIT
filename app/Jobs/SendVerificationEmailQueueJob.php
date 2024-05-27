<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Customs\Services\EmailVerificationService;

class SendVerificationEmailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    private $service;

    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->service = new EmailVerificationService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->service->sendVerificationLink($this->user);
    }
}
