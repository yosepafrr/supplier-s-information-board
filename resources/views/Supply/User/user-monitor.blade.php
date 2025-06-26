@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Monitoring Antrian Barang</h1>
                {{-- <p>Silahkan isi data-data dibawah.</p> --}}
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
        <div class="card mb-4 max-height-vh-70">
            <div class="table-responsive" id="antrian-container">
                @foreach ($batches as $batchIndex => $batch)
                    <table class="table align-items-center mb-0 batch-table" style="{{ $loop->first ? '' : 'display:none' }}">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">No Antrian</th>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 ps-2">Supplier
                                </th>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                    Nama Barang</th>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $supplyRowspanCounter = [];
                                foreach ($batch as $item) {
                                    $id = $item['supply']->id;
                                    if (!isset($supplyRowspanCounter[$id])) {
                                        $supplyRowspanCounter[$id] = 0;
                                    }
                                    $supplyRowspanCounter[$id]++;
                                }
                                $printed = [];
                            @endphp
                            @foreach ($batch as $item)
                                @php
                                    $supply = $item['supply'];
                                    $barang = $item['barang'];
                                @endphp
                                <tr>
                                    @if (!in_array($supply->id, $printed))
                                        <td class="py-3" rowspan="{{ $supplyRowspanCounter[$supply->id] }}">
                                            <p class=" px-5 font-weight-bold mb-0">{{ $supply->no_antrian }}</p>
                                        </td>
                                        <td class="py-3" rowspan="{{ $supplyRowspanCounter[$supply->id] }}">
                                            <p class="font-weight-bold mb-0">{{ $supply->nama_perusahaan }}</p>
                                        </td>
                                        @php
                                            $printed[] = $supply->id;
                                        @endphp
                                    @endif
                                    <td class="py-3">
                                        <p class="text-xs font-weight-bold mb-0 mx-3">{{ $barang->nama_barang }}</p>
                                    </td>
                                    <td class="py-3">
                                        <p class="text-xs font-weight-bold mb-0 mx-3">{{ $supply->no_antrian }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>

    {{-- FUNGSI REFRESH TABLE --}}
    <script>
        let current = 0;
        const tables = document.querySelectorAll('.batch-table');

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
        .batch-table {
            transition: opacity 0.5s ease;
        }
    </style>
    {{-- FUNGSI REFRESH TABLE --}}


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