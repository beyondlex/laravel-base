<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		//client_id, params, sign
        $input = $request->input();
        if (!isset($input['client_id'])) {
            throw new UnauthorizedHttpException('Client_id can not be empty.');
        }
        $client = Client::find($input['client_id']);
        if (!$client) {
            throw new UnauthorizedHttpException('Invalid client.');
        }
        if ($client->revoked) {
            throw new UnauthorizedHttpException('The client has been revoked.');
        }
        $secret = $client->secret;

        $params = $input;
        unset($params['sign']);
        ksort($params);
        $str = '';
        foreach ($params as $k=>$v) {
            if (!$v) continue;
            $str .= $k.'='.$v.';';
        }
        $str = $secret. $str;
        $sign = sha1($str);

//        Log::debug('authentication', [$sign]);

        if ($sign != $input['sign']) {
            throw new UnauthorizedHttpException('Invalid request');
        }

        \App::singleton('curato', function() use ($client) {
			$curato = new \stdClass();
			$curato->client = $client;
			return $curato;
		});

        return $next($request);
    }
}
