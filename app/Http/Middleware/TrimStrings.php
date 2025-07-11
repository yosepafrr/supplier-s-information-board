<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    // You may add attributes that should not be trimmed here
    protected $except = [
        //
    ];
}
