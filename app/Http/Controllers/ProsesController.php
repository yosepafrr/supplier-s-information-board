<?php

namespace App\Http\Controllers;

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
        // $supply = Supply::get();
        // $barang = Barang::get();
        // dd($supply);
        // dd($barang);
        return view("supply.user.user-monitor");
    }

    function registrasi()
    {
        return view("supply.user.user-reg");
    }

    // function submit(Request $request)
    // {
    //     $siswa = new Supply();
    //     $siswa->nis = $request->nis;
    //     $siswa->nama = $request->nama;
    //     $siswa->alamat = $request->alamat;
    //     $siswa->no_hp = $request->hp;
    //     $siswa->jenis_kelamin = $request->jk;
    //     $siswa->hobi = $request->hobi;
    //     $siswa->save();
    //     return redirect()->route('siswa.tampil');
    // }

    public function submit(Request $request)
    {
        DB::beginTransaction();

        try {
            // Debug step 1
            logger('Mulai menyimpan Supply');

            $supply = Supply::create([
                'tanggal' => now(),
                'nama_driver' => $request->nama_driver,
                'nopol' => $request->nopol,
                'nama_perusahaan' => $request->nama_perusahaan,
                'no_surat_jalan' => null,
            ]);

            logger('Supply berhasil: ' . $supply->id);

            // Debug step 2
            $barang = Barang::create([
                'nama_barang' => $request->nama_barang,
                'jumlah_barang' => $request->jumlah_barang,
                'keterangan' => null,
                'supply_id' => $supply->id,
            ]);

            logger('Barang berhasil: ' . $barang->id);

            DB::commit();

            return redirect()->route('supply.user.user-reg')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Gagal simpan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
