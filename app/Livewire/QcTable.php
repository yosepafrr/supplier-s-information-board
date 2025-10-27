<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Supply;
use Livewire\Component;

class QcTable extends Component
{
    public $seenIds = [];

    public function mount()
    {
        // Ambil seenIds dari session kalau ada
        $this->seenIds = session('seenIds', []);
    }

    public function render()
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");

        $supplies = Supply::with('barang')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('no_antrian')
            ->get();

        $flatData = collect();
        foreach ($supplies as $supply) {
            foreach ($supply->barang as $barang) {
                $isNew = !in_array($barang->id, $this->seenIds);

                $flatData->push([
                    'supply' => $supply,
                    'barang' => $barang,
                    'isNew'  => $isNew, // baru kalau belum pernah ada
                ]);
                // / Tambah ke seenIds biar next render tidak dianggap baru lagi
                if ($isNew) {
                    $this->seenIds[] = $barang->id;
                }
            }
        }
        // Simpan ke session
        session(['seenIds' => $this->seenIds]);


        return view('livewire.qc-table', compact('flatData', 'tanggal'));
    }
}
