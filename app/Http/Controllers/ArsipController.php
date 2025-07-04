<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ArsipController extends Controller
{
    public function arsipNg(Request $request)
    {
        // Ambil tanggal dari request (jika ada), atau biarkan NULL untuk menampilkan semua
        $tanggal = $request->tanggal;

        $query = DB::table('arsip_ng')->orderByDesc('tanggal_update_qc');

        if ($tanggal) {
            $query->whereDate('tanggal_masuk', $tanggal);
        }

        $arsip = $query->get();

        return view('arsip.ng', compact('arsip', 'tanggal'));
    }
    public function arsipHold(Request $request)
    {
        // Ambil tanggal dari request (jika ada), atau biarkan NULL untuk menampilkan semua
        $tanggal = $request->tanggal;

        $query = DB::table('arsip_hold')->orderByDesc('tanggal_update_qc');

        if ($tanggal) {
            $query->whereDate('tanggal_masuk', $tanggal);
        }

        $arsip = $query->get();

        return view('arsip.hold', compact('arsip', 'tanggal'));
    }
}
