<?php

namespace BRCas\Log\Middleware;

use BRCas\Log\Services\LogService;
use Closure;

class LogMiddleware
{
    private $service;

    public function __construct(LogService $service)
    {
        $this->service = $service;
    }
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ret = $next($request);
        $data = [
            "url" => $request->url(),
            "request" => [
                "method" => $request->method(),
            ],
            'response' => [
                'status_code' => $ret->getStatusCode(),
            ]
        ];

        if(count($request->except(['q']))) {
            $data['request'] += [
                "params" => $request->except(['q']),
            ];
        }

        LogService::add('oi', 'tese');
        
        $this->service->save($data);

        return $ret;
    }
}
