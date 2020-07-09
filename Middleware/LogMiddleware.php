<?php

namespace BRCas\Log\Middleware;

use BRCas\Log\Services\LogService;
use Closure;
use Illuminate\Support\Facades\Route;

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
                "route" => Route::current(),
            ],
            'response' => [
                'status_code' => $ret->getStatusCode(),
            ]
        ];

        if (!empty($value = Route::currentRouteName())) {
            $data["request"] += ["name" => $value];
        }

        if (!empty($value = Route::currentRouteAction())) {
            $data["request"] += ["action" => $value];
        }

        if(count($request->except(['q']))) {
            $data['request'] += [
                "params" => $request->except(['q']),
            ];
        }

        $response = null;
        $data['response'] += ['class' => get_class($ret)];

        switch ($data['response']['class']) {
            case \Illuminate\Http\JsonResponse::class:
                $response = json_decode($ret->getContent(), true);
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

        if ($response) {
            $data['response'] += ['return' => $response];
        }

        $this->service->save($data);

        return $ret;
    }
}
