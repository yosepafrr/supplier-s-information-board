@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div class="d-flex align-items-center justify-content-between w-full">
            <div class="mx-3">
                <h1 class="h4 font-weight-bold mb-0">Monitoring Antrian Barang</h1>
                <span class="fst-italic">Urutan antrian dari kiri atas ke kanan
                    bawah.</span>
            </div>
            <div>
                <form method="GET" action="{{ route('supply.user.user-monitor') }}" id="filter-form">
                    <div class="input-group input-group-outline my-3">
                        <input type="date" class="form-control " name="tanggal"
                            value="{{ request('tanggal') ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                            onchange="document.getElementById('filter-form').submit();">
                    </div>
                </form>
            </div>
        </div>
        @php
            $printedSuppliers = [];
        @endphp
        <div class="position-relative max-height-vh-80" id="antrian-container">
            @foreach ($batches as $batchIndex => $batch)
                <div
                    class="d-flex flex-wrap batch-view mb-4 position-absolute top-0 start-0 w-100 {{ $loop->first ? 'active' : 'hidden' }}">
                    @php
                        $printed = [];
                    @endphp
                    @foreach ($batch as $index => $item)
                        @php
                            $supply = $item['supply'];
                            $barang = $item['barang'];
                            $isFirst = !in_array($supply->id, $printed);
                            if ($isFirst)
                                $printed[] = $supply->id;
                        @endphp

                        @if ($loop->index < 2)
                            <div class="p-2 w-50">
                                <div class="card border-success mb-3 h-100">
                                    <div class="card-header bg-transparent border-success">
                                        <span class="text-2xl">Antrian {{ $supply->no_antrian }}</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-title text-6xl my-0 text-bold text-success">{{ $supply->nama_perusahaan }}</p>
                                        <p class="card-title text-4xl text-bold">{{ $supply->nama_driver }} | {{ $supply->nopol}}
                                        </p>
                                        <p class="card-text text-2xl">{{ $barang->nama_barang }} | {{ $barang->jumlah_barang }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-success">
                                        {{ $supply->no_antrian }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="p-2" style="width: 25%;">
                                <div class="card border-secondary mb-3 h-100">
                                    <div class="card-header bg-transparent border-success">
                                        Antrian {{ $supply->no_antrian }}
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-2xl text-success my-0">{{ $supply->nama_perusahaan }}</h5>
                                        <p class="card-title text-md text-bold">{{ $supply->nama_driver }} | {{ $supply->nopol}}
                                        </p>
                                        <p class="card-text text-sm">{{ $barang->nama_barang }} | {{ $barang->jumlah_barang }}</p>

                                    </div>
                                    <div class="card-footer bg-transparent border-success">
                                        {{ $supply->no_antrian }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>


        {{-- FUNGSI REFRESH OTOMATIS SETIAP 7 DETIK --}}
        <script>
            let current = 0;
            const tables = document.querySelectorAll('.batch-view');

            if (tables.length > 1) {
                setInterval(() => {
                    tables[current].style.opacity = 0;

                    setTimeout(() => {
                        tables[current].style.display = 'none';
                        current = (current + 1) % tables.length;
                        tables[current].style.display = '';
                        tables[current].style.opacity = 0;
                        setTimeout(() => {
                            tables[current].style.opacity = 1;
                        }, 50);
                    }, 500);
                }, 7000);
            }
        </script>
        <style>
            .batch-view {
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
                z-index: 0;
                pointer-events: none;
            }

            .batch-view.active {
                opacity: 1;
                z-index: 1;
                pointer-events: auto;
            }

            .batch-view.hidden {
                opacity: 0;
                z-index: 0;
                pointer-events: none;
            }

            #antrian-container {
                position: relative;
                min-height: 80vh;
                overflow: hidden;
            }
        </style>
        {{-- FUNGSI REFRESH OTOMATIS SETIAP 7 DETIK --}}



        {{-- FUNGSI REFRESH OTOMATIS KETIKA ADA DATA BARU --}}
        <script>
            let lastKnownUpdate = null;
            const tanggal = document.querySelector('input[name="tanggal"]').value;

            async function checkForUpdate() {
                try {
                    const res = await fetch(`/monitor/check-update?tanggal=${tanggal}`);
                    const data = await res.json();

                    if (!lastKnownUpdate) {
                        lastKnownUpdate = data.last_updated_at;
                    } else if (lastKnownUpdate !== data.last_updated_at) {
                        location.reload(); // data baru terdeteksi, reload halaman
                    }
                } catch (e) {
                    console.error("Gagal cek update:", e);
                }
            }


            // Cek setiap 5 detik
            setInterval(checkForUpdate, 5000);
        </script>
        {{-- FUNGSI REFRESH OTOMATIS KETIKA ADA DATA BARU --}}




@endsection