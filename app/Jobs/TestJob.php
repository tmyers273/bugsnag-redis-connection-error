<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $redis;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $clientCount = $this->getClientCount();
        echo("There are $clientCount connected clients\n");

        Bugsnag::registerCallback(function ($report) {
            $report->setMetaData([
                'Data' => [
                    'Very Fake',
                    'Data Lives',
                    'Here!'
                ]
            ]);
        });

        $this->callRedis();
    }

    protected function getClientCount()
    {
        return Redis::info()['Clients']['connected_clients'];
    }

    protected function callRedis()
    {
        $this->redis->get('test');
        throw new \Exception('Test Exception');
    }
}
