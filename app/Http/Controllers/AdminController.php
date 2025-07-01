<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Supply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function qc(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");

        $supplies = Supply::with('barangs')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('no_antrian')
            ->get();

        $flatData = collect();
        foreach ($supplies as $supply) {
            foreach ($supply->barangs as $barang) {
                $flatData->push([
                    'supply' => $supply,
                    'barang' => $barang,
                ]);
            }
        }

        return view("supply.admin.qc", compact('flatData', 'tanggal'));
    }
    public function updateStatusOnQc(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);
        $barang->status = $request->status;
        $barang->keterangan = $request->catatan;
        $barang->save();

        return redirect()->back()->with('success', 'Status barang berhasil diperbarui.');
    }
}
