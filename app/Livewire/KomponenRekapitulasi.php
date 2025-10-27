<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Barang;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomponenRekapitulasi extends Component
{
    public $range = 7; // default 1 minggu
    public function render(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today("Asia/Jakarta");

        $range = $request->get('range', 7);
        $endDate = Carbon::today("Asia/Jakarta");
        $startDate = $endDate->copy()->subDays($range);

        // / Ambil data group by tanggal & status
        $raw = DB::table('barang')
            ->selectRaw('DATE(created_at) as date, status, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();

        // Siapkan array harian
        $dailyCounts = [];

        foreach ($raw as $row) {
            $date = $row->date;

            if (!isset($dailyCounts[$date])) {
                $dailyCounts[$date] = [
                    'ok' => 0,
                    'not_good' => 0,
                    'hold' => 0,
                    'tanpa_status' => 0,
                    'total' => 0,
                ];
            }

            $status = trim($row->status); // buang spasi kiri/kanan

            if ($status === null || $status === '') {
                $key = 'tanpa_status';
            } else {
                switch (strtolower($status)) {
                    case 'ok':
                        $key = 'ok';
                        break;
                    case 'not good':
                        $key = 'not_good';
                        break;
                    case 'hold':
                        $key = 'hold';
                        break;
                    default:
                        $key = 'tanpa_status'; // fallback
                        break;
                }
            }

            $dailyCounts[$date][$key] = $row->total;
            $dailyCounts[$date]['total'] += $row->total; // ✅ total harian diisi
        }


        $counts = [
            'ok' => Barang::whereDate('created_at', $tanggal)->where('status', 'Ok')->count(),
            'not_good' => Barang::whereDate('created_at', $tanggal)->where('status', 'Not Good')->count(),
            'hold' => Barang::whereDate('created_at', $tanggal)->where('status', 'Hold')->count(),
            'total' => Barang::whereDate('created_at', $tanggal)->count(),
        ];



        // $dates = array_keys($dailyCounts);
        // $okCounts = array_column($dailyCounts, 'ok');
        // $notGoodCounts = array_column($dailyCounts, 'not_good');
        // $holdCounts = array_column($dailyCounts, 'hold');

        // foreach ($dailyCounts as $date => $counts) {
        //     $dailyCounts[$date]['ok'] = $counts['Ok'] ?? 0;
        //     $dailyCounts[$date]['not_good'] = $counts['Not Good'] ?? 0;
        //     $dailyCounts[$date]['hold'] = $counts['Hold'] ?? 0;


        //     // optional: buang key aslinya
        //     unset($dailyCounts[$date]['Ok'], $dailyCounts[$date]['Not Good'], $dailyCounts[$date]['Hold']);
        // }



        // dd($dailyCounts);

        return view('livewire.komponen-rekapitulasi', compact(
            'counts',
            'dailyCounts',
            'tanggal',
            'range'
        ));
    }
}
