<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateJsonApiHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('accept') !== 'application/vnd.api+json'){
             //editamos aqui lanzando una http exception
        throw new HttpException(406);
        }
        if($request->isMethod('POST') || $request->isMethod('PATCH') ){
            if ($request->header('content-type') !== 'application/vnd.api+json'){
                //editamos aqui lanzando una http exception
           throw new HttpException(415); 
        }
      
    }
    return $next($request)->withHeaders([
        'content-type' => 'application/vnd.api+json'
    ]);
}
}
