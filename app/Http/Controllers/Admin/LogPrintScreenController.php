<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PrintScreenLog;
use App\Models\User\User;
use Illuminate\Http\Request;

class LogPrintScreenController extends Controller
{
    public function store(Request $request)
    {
        PrintScreenLog::create([
            'user_id' => $request->get('user'),
            'url'     => $request->get('url'),
        ]);

        return 'and thats the way it is';
    }
}
