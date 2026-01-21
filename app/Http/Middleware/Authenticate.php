<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // ✅ ตรวจสอบว่าถ้าเป็นการเรียกใช้งานในส่วนของ Admin (URL มีคำว่า admin)
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // หากไม่ใช่ส่วนของ admin ให้ส่งไปหน้า login ปกติของเว็บไซต์
            return route('login');
        }
    }
}