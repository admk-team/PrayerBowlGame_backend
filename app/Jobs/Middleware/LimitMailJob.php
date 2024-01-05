<?php

namespace App\Jobs\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class LimitMailJob
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        Redis::throttle('key')
            ->block(0)->allow(1)->every(4)
            ->then(function () use ($job, $next) {
                $next($job);
            }, function () use ($job) {
                $job->release(4);
            });
    }
}
