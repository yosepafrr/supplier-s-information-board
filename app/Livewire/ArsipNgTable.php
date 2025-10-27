<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArsipNgTable extends Component
{
    public function render(Request $request)
    {
        // Ambil tanggal dari request (jika ada), atau biarkan NULL untuk menampilkan semua
        $tanggal = $request->tanggal;

        $query = DB::table('barang')
            ->join('supply', 'barang.supply_id', '=', 'supply.id')
            ->where('status', 'Not Good')
            ->orderByDesc('status_qc_updated_at');

        if ($tanggal) {
            $query->whereDate('supply.tanggal', $tanggal);
        }

        $arsip = $query->get();

        return view('livewire.arsip-ng-table', compact('arsip', 'tanggal'));
    }
}
