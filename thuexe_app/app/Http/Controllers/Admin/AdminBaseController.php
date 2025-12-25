<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class AdminBaseController extends Controller
{
    public function callAction($method, $parameters)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return parent::callAction($method, $parameters);
    }
}
