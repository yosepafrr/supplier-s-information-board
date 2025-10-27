<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Supply;
use Livewire\Component;

class PpicTable extends Component
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
        $supplies = Supply::with(['barang' => function ($q) {
            $q->orderBy('status_qc_updated_at', 'asc');
        }])
            ->whereDate('tanggal', $tanggal)
            ->get();

        $flatData = collect();
        foreach ($supplies as $supply) {
            foreach ($supply->barang as $barang) {
                $isNew = !in_array($barang->id, $this->seenIds);
                if ($barang->status === 'Ok' || $barang->status === 'Approved oleh PPIC') {
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
        }

        // / Group berdasarkan supply_id
        $grouped = $flatData->groupBy(function ($item) {
            return $item['supply']->id;
        });

        // Lalu sort barang di dalam tiap supply berdasarkan status_qc_updated_at
        $grouped = $grouped->map(function ($items) {
            return $items->sortBy(function ($item) {
                return $item['barang']->status_qc_updated_at;
            })->values();
        });

        // 3. Urutkan antar-supply berdasarkan status barang paling baru (misalnya max timestamp)
        $grouped = $grouped->sortBy(function ($items) {
            // Ambil barang terakhir (paling baru setelah sort)
            return optional($items->max('barang.status_qc_updated_at'));
        });

        // Flatten lagi biar tetap bisa dipakai di Blade
        $flatData = $grouped->flatten(1)->values();


        return view('livewire.ppic-table', compact('flatData', 'tanggal'));
    }
}
