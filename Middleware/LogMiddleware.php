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

        $response = null;

        switch(get_class($ret)){
            case \Illuminate\Http\JsonResponse::class:
                $response = $ret->getContent();
            break;
            break;
            case \Illuminate\Http\RedirectResponse::class:
                $response = "Page is redirect";
                $data['response'] += ['url' => $ret->getTargetUrl()];
            break;
            case \Illuminate\Http\Response::class:
                $response = "Page is HTML";
            break;
            default:
                dd($ret);
            break;
        }

        if($response){
            $data['response'] += ['return' => $response];
        }

        $this->service->save($data);

        return $ret;
    }
}
