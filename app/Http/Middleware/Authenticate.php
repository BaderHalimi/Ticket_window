<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
    
            if ($request->is('seller') || $request->is('seller/*')) {
                return route('seller.login');
            }
            if ($request->is('employee') || $request->is('employee/*')) {
                return route('employee.login');
            }
            if ($request->is('checker') || $request->is('checker/*')) {
                return route('checker.login');
            }
    
    
          
            return route('visitor.login');
        }
    }
    
}
