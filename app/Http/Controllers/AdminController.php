<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function qc(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");

        $supplies = Supply::with('barang')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('no_antrian')
            ->get();

        $flatData = collect();
        foreach ($supplies as $supply) {
            foreach ($supply->barang as $barang) {
                $flatData->push([
                    'supply' => $supply,
                    'barang' => $barang,
                ]);
            }
        }

        return view("supply.admin.qc", compact('flatData', 'tanggal'));
    }

    public function ppic(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");

        $supplies = Supply::with('barang')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('no_antrian')
            ->get();

        $flatData = collect();
        foreach ($supplies as $supply) {
            foreach ($supply->barang as $barang) {
                if ($barang->status === 'Ok' || $barang->status === 'Approved oleh PPIC') {
                    $flatData->push([
                        'supply' => $supply,
                        'barang' => $barang,
                    ]);
                }
            }
        }

        return view("supply.admin.ppic", compact('flatData', 'tanggal'));
    }

    public function approve(Request $request)
    {
        // Validasi
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
        ]);

        // Update status barang
        $barang = Barang::findOrFail($request->barang_id);
        $barang->status_on_ppic = 'Approved';
        $barang->progress_status = 'Approved oleh PPIC';
        $barang->save();

        return redirect()->back()->with('success', 'Status barang berhasil disetujui.');
    }

    public function updateStatusOnQc(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);
        $status = $request->status;
        $barang->status = $status;
        $barang->keterangan = $request->catatan;
        $barang->status_qc_updated_at = now();

        // Update progress_status
        if ($status === 'Ok') {
            $barang->progress_status = 'On Progress PPIC';
        } elseif ($status === 'Not Good') {
            $barang->progress_status = 'Status Barang: Not Good';

            // Simpan ke arsip_ng
            $supply = Supply::findOrFail($barang->supply_id);
            DB::table('arsip_ng')->insert([
                'barang_id' => $barang->id,
                'supply_id' => $supply->id,
                'tanggal_masuk' => $supply->tanggal,
                'jam_masuk' => $supply->jam,
                'nama_barang' => $barang->nama_barang,
                'jumlah_barang' => $barang->jumlah_barang,
                'nama_perusahaan' => $supply->nama_perusahaan,
                'nama_driver' => $supply->nama_driver,
                'nopol' => $supply->nopol,
                'keterangan' => $request->catatan,
                'tanggal_update_qc' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($status === 'Hold') {
            $barang->progress_status = 'Status Barang: Hold';

            // Simpan ke arsip_hold
            $supply = Supply::findOrFail($barang->supply_id);
            DB::table('arsip_hold')->insert([
                'barang_id' => $barang->id,
                'supply_id' => $supply->id,
                'tanggal_masuk' => $supply->tanggal,
                'jam_masuk' => $supply->jam,
                'nama_barang' => $barang->nama_barang,
                'jumlah_barang' => $barang->jumlah_barang,
                'nama_perusahaan' => $supply->nama_perusahaan,
                'nama_driver' => $supply->nama_driver,
                'nopol' => $supply->nopol,
                'keterangan' => $request->catatan,
                'tanggal_update_qc' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $barang->save();

        return redirect()->back()->with('success', 'Status barang berhasil diperbarui.');
    }
    public function inputSuratJalan(Request $request)
    {
        // Update Supply
        $supply = Supply::findOrFail($request->supply_id);
        $supply->no_surat_jalan = $request->no_surat_jalan;
        $supply->save();

        return redirect()->back()->with('success', 'Nomor surat jalan berhasil disimpan.');
    }


    // Notification methods
    public function checkUpdateQc()
    {
        $latest = DB::table('barang')
            ->whereDate('created_at', Carbon::today())
            ->latest('created_at')
            ->first();

        return response()->json([
            'has_new' => $latest ? $latest->created_at > session('last_qc_data', '2000-01-01') : false,
            'last_time' => $latest?->created_at,
        ]);
    }

    public function checkUpdatePpic()
    {
        $latest = DB::table('barang')
            ->where('status', 'Ok')
            ->whereDate('status_qc_updated_at', Carbon::today())
            ->latest('status_qc_updated_at')
            ->first();

        return response()->json([
            'has_new' => $latest ? $latest->status_qc_updated_at > session('last_ppic_data', '2000-01-01') : false,
            'last_time' => $latest?->status_qc_updated_at,
        ]);
    }
}
