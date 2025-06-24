<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProsesController extends Controller
{
    function dashboard()
    {
        return view("supply.dashboard");
    }

    function test()
    {
        return view("supply.user.user-test");
    }

    function monitor_user()
    {
        $supplies = Supply::with('barangs')->get();


        return view("supply.user.user-monitor", compact("supplies"));
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
            // Jam reset: setiap hari jam 16:00
            $now = Carbon::now('Asia/Jakarta');
            $resetTime = Carbon::today('Asia/Jakarta')->setTIme(23, 59);

            // Jika sekarang masih sebelum jam 16:00, maka resetTime adalah kemarin jam 16:00
            if ($now->lessThan($resetTime)) {
                $resetTime = $resetTime->subDay(); // resetTime jadi kemarin 16:00
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
                'tanggal' => now(),
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
