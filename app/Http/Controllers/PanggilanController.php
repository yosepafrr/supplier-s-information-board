<?php

namespace App\Http\Controllers;

use App\Models\Panggilan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanggilanController extends Controller
{
    // public function panggil(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'barang_id' => 'required|exists:barang,id',
    //         'dari' => 'required|in:QC,PPIC',
    //         'pesan' => 'required|string',
    //     ]);

    //     // Simpan data pemanggilan ke tabel panggilan
    //     $panggilan = Panggilan::create([
    //         'barang_id' => $request->barang_id,
    //         'dari' => $request->dari,
    //         'pesan' => $request->pesan,
    //         'sudah_ditampilkan' => false, // Default value
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Panggilan berhasil dibuat.',
    //         'data' => $panggilan,
    //     ]);
    // }
    // public function showMonitor()
    // {
    //     // Ambil data panggilan yang belum ditampilkan
    //     $panggilan = Panggilan::where('sudah_ditampilkan', false)->get();

    //     // Kirim data ke view
    //     return view('supply.user.user-monitor', compact('panggilan'));
    // }
}
