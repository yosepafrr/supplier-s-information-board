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
        // Ambil tanggal dari request (jika ada), atau biarkan NULL untuk menampilkan semua
        $tanggal = $request->tanggal;

            $query = DB::table('barang')
                ->join('supply', 'barang.supply_id', '=', 'supply.id')
                ->where('status', 'Not Good')
                ->orderByDesc('status_qc_updated_at');

            if ($tanggal) {
                $query->whereDate('supply.tanggal', $tanggal);
            }

            $arsip = $query->get();
            return view('arsip.ng', compact('arsip', 'tanggal'));
    }
    public function arsipHold(Request $request)
    {
        // Ambil tanggal dari request (jika ada), atau biarkan NULL untuk menampilkan semua
        $tanggal = $request->tanggal;

        $query = DB::table('barang')
            ->join('supply', 'barang.supply_id', '=', 'supply.id')
            ->where('status', 'Hold')
            ->orderByDesc('status_qc_updated_at');

        if ($tanggal) {
            $query->whereDate('supply.tanggal', $tanggal);
        }

        $arsip = $query->get();

        return view('arsip.hold', compact('arsip', 'tanggal'));
    }
}
