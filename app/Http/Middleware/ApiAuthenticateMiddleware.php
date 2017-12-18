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
        $clientId = $request->header('clientId');
        $sign = $request->header('sign');
        if (!isset($clientId)) {
            throw new UnauthorizedHttpException('Client_id can not be empty.');
        }
        $client = Client::find($clientId);
        if (!$client) {
            throw new UnauthorizedHttpException('Invalid client.');
        }
        if ($client->revoked) {
            throw new UnauthorizedHttpException('The client has been revoked.');
        }
        $secret = $client->secret;

        $params = $input;
//        unset($params['sign']);
        ksort($params);
        $str = '';
        foreach ($params as $k=>$v) {
            if (!$v) continue;
            if (!is_string($v)) continue;
            $str .= $k.'='.$v.';';
        }
        $str = $secret. $str;
        $signExpect = sha1($str);

//        Log::debug('authentication', [$sign]);

        if ($signExpect != $sign) {
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
