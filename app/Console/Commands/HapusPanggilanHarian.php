<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HapusPanggilanHarian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panggilan:hapus-harian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus panggilan harian yang sudah tidak diperlukan lagi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('panggilan')->delete();
        $this->info('Panggilan harian telah dihapus.');
    }
}
