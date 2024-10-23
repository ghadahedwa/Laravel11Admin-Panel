<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        //dd($guards);
        $guards=empty($guards)?[null]:$guards;
        foreach ($guards as $guard){
            #if guard is authenticated
            if(Auth::guard($guard)->check()){
                Auth::shouldUse($guard);
                return $next($request);
            }
        }
        #handel un authenticated session
        $this->unauthenticated($guards);
    }
    protected function unauthenticated(array $guards){
        throw new AuthenticationException(
            'Unauthenticated',$guards,$this->redirectTo()
        );
    }

    protected function redirectTo(){
        #For admin
        //dd(Route::is('superadmin.*'));

        if(Route::is('admin.*')){
            return route('admin.login');
        }
        elseif (Route::is('superadmin.*')){
            return route('superadmin.login');
        }
        #for user
        return route('login');
    }
}
