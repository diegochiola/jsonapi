<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateJsonapiDocument
{

    public function handle(Request $request, Closure $next): Response
    {
        //verificaion que si el metodo es post
        if($request->isMethod('POST' || $request->isMethod('PATCH'))){
            $request->validate([
                'data' => ['required']
            ]);
        }
        return $next($request);
    }
}
