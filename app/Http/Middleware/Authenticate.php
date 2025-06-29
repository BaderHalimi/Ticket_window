<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // التحقق من الـ guard المستخدم
            if ($request->is('merchant/*')) {
                return route('login');  // إذا كان المستخدم مشرف
            } elseif ($request->is('user/*')) {
                return route('customer.login');  // إذا كان المستخدم عميل
            } elseif ($request->is('admin/*')) {
                return route('admin.login');  // إذا كان المستخدم عميل
            }

            // توجيه افتراضي في حال عدم تحديد guard
            return route('login');
        }
    }
}
