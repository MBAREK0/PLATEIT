<?php

namespace App\Jobs;

use App\Customs\Services\PointsSestemService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailyRewardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_user;
    private $service;


    /**
     * Create a new job instance.
     */
    public function __construct($_user)
    {
        $this->_user = $_user;
        $this->service = new PointsSestemService;
    }


    public function handle(): void
    {
        $this->service->visit_our_app_points($this->_user);
    }
}
