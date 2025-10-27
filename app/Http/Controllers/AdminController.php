<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function qc(Request $request)
    {
        return view("supply.admin.qc");
    }

    public function ppic(Request $request)
    {
        return view("supply.admin.ppic");
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
        } elseif ($status === 'Hold') {
            $barang->progress_status = 'Status Barang: Hold';
        }

        // === Foto handling ===
        if ($request->has('foto')) {
            $fotoPaths = [];

            foreach ($request->foto as $foto) {
                $image = str_replace('data:image/png;base64,', '', $foto);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid() . '.png';

                Storage::disk('public')->put('foto_barang/' . $imageName, base64_decode($image));

                $fotoPaths[] = 'foto_barang/' . $imageName;
            }

            // Kalau sebelumnya sudah ada foto, gabungkan
            $existingPhotos = $barang->foto_barang ? json_decode($barang->foto_barang, true) : [];
            $barang->foto_barang = json_encode(array_merge($existingPhotos, $fotoPaths));
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
