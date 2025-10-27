<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function arsipNg(Request $request)
    {
            return view('arsip.ng');
    }
    public function arsipHold(Request $request)
    {
        return view('arsip.hold');
    }
}
