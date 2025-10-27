<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Supply;
use Livewire\Component;
use Illuminate\Http\Request;


class MonitorTable extends Component
{
    public function render(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");
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

        return view('livewire.monitor-table', ['batches' => $batches]);
    }
}
