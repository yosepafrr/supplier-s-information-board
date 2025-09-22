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
                                        @if ($barang->progress_status)
                                            {{ $barang->progress_status }}
                                        @else
                                            <span>On Progress QC</span>
                                        @endif
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
                                        @if ($barang->progress_status)
                                            {{ $barang->progress_status }}
                                        @else
                                            <span>On Progress QC</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- MODAL PEMANGGILAN --}}
        <div class="modal fade" id="monitorModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered w-100 h-100" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title font-weight-light text-white">Mohon Perhatian</h5>
                    </div>
                    <div class="modal-body">
                        <h5 id="monitorModalMessage"></h5>
                    </div>
                    <div class="modal-footer">
                        <h5 class="modal-title font-weight-light">Terimakasih Atas Perhatiannya.</h5>
                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL PEMANGGILAN --}}

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



        {{-- FUNGSI REFRESH OTOMATIS KETIKA ADA DATA BARU ATAU STATUS BERUBAH --}}
        <script>
            let lastKnownUpdate = null;
            let lastKnownStatusHash = null;

            const tanggal = document.querySelector('input[name="tanggal"]').value;

            async function checkForUpdate() {
                try {
                    const res = await fetch(`/monitor/check-update?tanggal=${tanggal}`);
                    const data = await res.json();

                    if (!lastKnownUpdate || !lastKnownStatusHash) {

                        // if (data.last_updated_at || data.status_hash) {
                        //     location.reload();
                        // }
                        lastKnownUpdate = data.last_updated_at;
                        lastKnownStatusHash = data.status_hash;
                    } else {
                        const updated = lastKnownUpdate !== data.last_updated_at;
                        const statusChanged = lastKnownStatusHash !== data.status_hash;

                        if (updated || statusChanged) {
                            location.reload(); // reload jika data atau status berubah
                        }
                    }
                } catch (e) {
                    console.error("Gagal cek update:", e);
                }
            }

            setInterval(checkForUpdate, 2000); // Cek setiap 2 detik
        </script>
        {{-- FUNGSI REFRESH OTOMATIS KETIKA ADA DATA BARU --}}


        {{-- FUNGSI PEMANGGILAN --}}
        <audio id="notifSound" src="{{ asset('assets/sound/pengumuman2.mp3') }}" preload="auto"></audio>
        <script>
            let lastShownId = localStorage.getItem("lastShownPanggilanId");
            const sound = document.getElementById('notifSound');
            sound.volume = 0.5;

            async function checkForNewPanggilan() {
                try {
                    const res = await fetch('/monitor/check-panggilan');
                    const data = await res.json();

                    if (data && String(data.id) !== String(lastShownId)) {
                        showModal(data.pesan);
                        localStorage.setItem("lastShownPanggilanId", data.id);
                        lastShownId = String(data.id);
                    }

                } catch (err) {
                    console.error("Gagal mengambil data panggilan:", err);
                }
            }

            function showModal(pesan) {
                const modal = new bootstrap.Modal(document.getElementById('monitorModal'));
                document.getElementById('monitorModalMessage').innerText = pesan;
                modal.show();
                document.activeElement.blur(); // cegah aria-hidden warning

                // ⏯️ Mainkan suara
                if (sound) {
                    sound.currentTime = 0; // mulai dari awal
                    sound.play().catch((e) => {
                        console.warn('Gagal memutar suara:', e);
                    });
                }


                setTimeout(() => {
                    modal.hide();
                }, 7000);
            }

            setInterval(checkForNewPanggilan, 2000);
        </script>
        {{-- FUNGSI PEMANGGILAN --}}




@endsection