<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Customs\Services\PointsSestemService;

class SystemOfPointsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_user;
    private $service;
    protected $_type;
    protected $methodName;

    /** 
     * Create a new job instance.
     */
    public function __construct($_user, $_type)
    {
        $this->_user = $_user;
        $this->_type = $_type;
        $this->service = new PointsSestemService;
    }


    public function add_points(){
        $this->methodName = 'add_points';
    }
    public function remove_points(){
        $this->methodName = 'remove_points';
    }

    public function get_author_id($model , $primery_key){
       $author_id =  $this->service->get_user($model , $primery_key);
       $this->_user = $author_id;
    }
    public function handle(): void
    {
        $method = $this->methodName;
        $this->service->$method($this->_user, $this->_type);
    }
}
