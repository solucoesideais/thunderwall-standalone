<?php

namespace App\Http\Controllers;

class RedirectsController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return redirect('/login');
        }

        return redirect('/home');
    }
}
