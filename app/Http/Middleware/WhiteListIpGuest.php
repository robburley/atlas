<?php

namespace App\Http\Middleware;

use Closure;

class WhiteListIpGuest
{
    public $allowedIps = [
        '5.28.53.15', //Sunderland
        '5.28.53.16', //Sunderland
        '5.28.53.17', //Sunderland
        '5.28.53.18', //Sunderland
        '5.28.53.19', //Sunderland
        '5.28.53.20', //Sunderland
        '5.28.53.21', //Sunderland
        '5.28.53.22', //Sunderland
        '5.28.53.23', //Sunderland
        '5.28.53.24', //Sunderland
        '5.28.53.25', //Sunderland
        '5.28.53.26', //Sunderland
        '5.28.53.27', //Sunderland
        '5.28.53.28', //Sunderland
        '5.28.53.29', //Sunderland
        '5.28.53.30', //Sunderland
        '5.28.53.31', //Sunderland
        '5.28.53.32', //Sunderland
        '5.28.53.33', //Sunderland
        '5.28.53.33', //Sunderland
        '5.28.53.35', //Sunderland
        '195.62.204.245', //Sunderland
        '212.57.225.167', //Stoke
        '78.158.33.131', //Manchester
        '212.57.225.138', //Nantwich
        '195.62.195.78', //Nantwich
        '51.148.139.114', //Nantwhich
        '192.168.10.1', //dev
    ];

    public $allowedRoles = [
        1,
        5,
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            (!auth()->user() && !collect($this->allowedIps)->contains(request()->server->get('REMOTE_ADDR'))) ||
            (
                auth()->user() &&
                !collect($this->allowedRoles)->contains(auth()->user()->role_id) &&
                !collect($this->allowedIps)->contains(request()->server->get('REMOTE_ADDR')) &&
                !auth()->user()->hasPermission('remote_login')
            )
        ) {
            abort(403);
        }

        return $next($request);
    }
}
