<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $consumer_key = "kALA3qqUCYJ8xmaEpQF0LyvDAOMBwOIlD31aWJVQ4RbISvA7";
        $consumer_secret = "slLXYm43tJJnaOOFApaBxBvuN1bFMEVXlfaolAtiMJJJlISOWWpJLtGEG9hNafTJ";
        $auth_key = base64_encode($consumer_key . ":" .$consumer_secret);
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $auth_key
        ])->get("https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");
        // Log::debug($response["access_token"]);
        $request->request->add(['token' => $response["access_token"]]);
        return $next($request);
    }
}
