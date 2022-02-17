<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        header("Access-Control-Allow-Origin: *");

        $headers = [
            'Access-Control-Allow-Origin' => 'https://opendata.euskadi.eus/contenidos/ds_recursos_turisticos/hoteles_de_euskadi/opendata/alojamientos.json',
            'Access-Control-Max-Age' => '3600',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Origin, Accept, Content-Type, X-Requested-With, Access-Control-Allow-Headers, Origin, Authorization',
            'Accept' => 'application/json'
        ];

        if ($request->getMethod() == "OPTIONS") {
            return response()->make('OK', 200, $headers);
        }

        $response = $next($request);
        
        foreach ($headers as $key => $value)
            $response->header($key, $value);

        return $response;

    }
}
