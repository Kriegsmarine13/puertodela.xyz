<?php

namespace App\Http\Middleware;

use Closure;

class Administrate
{
    /*
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if(!isset($_COOKIE['adminAuth']))
        {
            if($_SERVER['REQUEST_URI'] !== '/admin')
            {
                return redirect()->to('/admin');
            }
        }
        elseif(isset($_COOKIE['adminAuth']))
        {
            if($_SERVER['REQUEST_URI'] == '/admin')
            {
                return redirect()->to('/admin/main');
            }
        }
        return $next($request);

    }
}