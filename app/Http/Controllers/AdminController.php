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

    public function ppic(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");

        $supplies = Supply::with('barangs')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('no_antrian')
            ->get();

        $flatData = collect();
        foreach ($supplies as $supply) {
            foreach ($supply->barangs as $barang) {
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
    public function updateStatusOnQc(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);
        $status = $request->status;
        $barang->status = $request->status;
        $barang->keterangan = $request->catatan;

        // Logika otomatis mengisi progress_status berdasarkan status
        if ($status === 'Ok') {
            $barang->progress_status = 'On Progress PPIC';
        } elseif ($status === 'Not Good') {
            $barang->progress_status = 'Status Barang: Not Good';
        } elseif ($status === 'Hold') {
            $barang->progress_status = 'Status Barang: Hold';
        }

        $barang->save();

        logger('STATUS: [' . $status . ']');

        return redirect()->back()->with('success', 'Status barang berhasil diperbarui.');
    }

    public function approve(Request $request)
    {
        // Update status barang
        $barang = Barang::findOrFail($request->barang_id);
        $barang->status_on_ppic = 'Approved';

        // Tambahan logika: set kolom status = Approved juga
        $barang->status = 'Approved oleh PPIC'; // "Approved oleh PPIC"

        // Update progress_status juga biar konsisten
        $barang->progress_status = 'Approved oleh PPIC'; // "Approved oleh PPIC"
        $barang->save();



        return redirect()->back()->with('success', 'Status barang berhasil disetujui.');
    }

    public function inputSuratJalan(Request $request)
    {
        // Update Supply
        $supply = Supply::findOrFail($request->supply_id);
        $supply->no_surat_jalan = $request->no_surat_jalan;
        $supply->save();

        return redirect()->back()->with('success', 'Nomor surat jalan berhasil disimpan.');
    }
}
