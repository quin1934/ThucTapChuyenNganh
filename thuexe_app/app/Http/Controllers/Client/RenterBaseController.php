<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class RenterBaseController extends Controller
{
    public function callAction($method, $parameters)
    {
        if (!Auth::guard('khach')->check()) {
            return redirect()->route('client.login');
        }

        return parent::callAction($method, $parameters);
    }
}
