<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Supply;
use App\Models\Panggilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ProsesController extends Controller
{
    public function cekUpdateTerakhir(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        // Ambil data terakhir yang diubah
        $lastUpdated = DB::table('barang')
            ->whereDate('updated_at', $tanggal)
            ->orderByDesc('updated_at')
            ->value('updated_at');

        // Ambil semua progress_status lalu buat hash untuk deteksi perubahan isi
        $statusList = DB::table('barang')
            ->whereDate('updated_at', $tanggal)
            ->pluck('progress_status')
            ->implode(',');

        $statusHash = md5($statusList);

        return response()->json([
            'last_updated_at' => $lastUpdated,
            'status_hash' => $statusHash,
        ]);
    }

    public function cekPanggilanTerbaru(Request $request)
    {
        $panggilanTerbaru = DB::table('panggilan')->latest('created_at')->first();

        return response()->json([
            'id' => $panggilanTerbaru->id,
            'pesan' => $panggilanTerbaru->pesan,
            'updated_at' => $panggilanTerbaru->updated_at,
        ]);
    }
    function dashboard()
    {
        return view("supply.dashboard");
    }
    public function panggil(Request $request)
    {
        // Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'dari' => 'required|in:QC,PPIC',
            'pesan' => 'required|string',
        ]);

        // Simpan data pemanggilan ke tabel panggilan
        $panggilan = Panggilan::create([
            'barang_id' => $request->barang_id,
            'dari' => $request->dari,
            'pesan' => $request->pesan,
            'sudah_ditampilkan' => false, // Default value
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Panggilan berhasil dibuat.',
            'data' => $panggilan,
        ]);
    }


    function monitor_user(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");

        // Ambil data panggilan terakhir
        $lastPanggilan = DB::table('panggilan')->latest('id')->first();
        $lastPanggilanId = $lastPanggilan ? $lastPanggilan->id : null;

        $supplies = Supply::with('barang')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('no_antrian')
            ->get();

        $flatenned = collect();
        foreach ($supplies as $supply) {
            foreach ($supply->barang as $barang) {
                $flatenned->push([
                    'supply' => $supply,
                    'barang' => $barang,
                ]);
            }
        }

        $batches = $flatenned->chunk(6);


        return view("supply.user.user-monitor", ['batches' => $batches], compact('lastPanggilanId', 'tanggal'));
    }

    function registrasi()
    {
        return view("supply.user.user-reg");
    }


    public function submit(Request $request)
    {
        DB::beginTransaction();

        try {
            // MEMBUAT NOMOR ANTRIAN YANG RESET DI JAM TERTENTU
            // Jam reset: setiap hari jam 23:59
            $now = Carbon::now('Asia/Jakarta');
            $resetTime = Carbon::today('Asia/Jakarta')->setTime(23, 59);

            if ($now->lessThan($resetTime)) {
                $resetTime = $resetTime->subDay(); // resetTime jadi kemarin 23:59
            }

            // Cari antrian terakhir setelah waktu reset
            $latest = Supply::where('created_at', '>=', $resetTime)
                ->orderBy('no_antrian', 'desc')
                ->first();

            $nomorAntrian = $latest ? $latest->no_antrian + 1 : 1;
            // MEMBUAT NOMOR ANTRIAN YANG RESET DI JAM TERTENTU
            logger('Nomor antrian terakhir: ' . ($latest ? $latest->no_antrian : 'Belum ada'));
            logger('Akan disimpan: ' . $nomorAntrian);
            logger('Carbon now(): ' . now());
            logger('Carbon timezone: ' . now()->timezoneName);
            logger('Data latest full: ' . json_encode($latest));



            // Debug step 1
            logger('Mulai menyimpan Supply');

            $supply = Supply::create([
                'tanggal' => now()->toDateString(),
                'jam' => now(),
                'nama_driver' => $request->nama_driver,
                'nopol' => $request->nopol,
                'nama_perusahaan' => $request->nama_perusahaan,
                'no_surat_jalan' => null,
                'no_antrian' => $nomorAntrian,
            ]);

            logger('Supply berhasil: ' . $supply->id);
            logger($request->all()); // Untuk melihat isi request yang masuk

            // Debug step 2
            foreach ($request->barang as $barang) {
                $createdBarang = Barang::create([
                    'nama_barang' => $barang['nama_barang'],
                    'jumlah_barang' => $barang['jumlah_barang'],
                    'keterangan' => null,
                    'supply_id' => $supply->id,
                ]);
            }


            logger('Barang berhasil: ' . $createdBarang->id);

            DB::commit();

            return redirect()->route('supply.user.user-reg')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Gagal simpan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
