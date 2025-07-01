@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Monitoring Antrian Barang</h1>
            </div>
            <div>
                <form method="GET" action="{{ route('supply.admin.qc') }}" id="filter-form">
                    <div class="input-group input-group-outline my-3">
                        <input type="date" class="form-control" name="tanggal"
                            value="{{ request('tanggal') ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                            onchange="document.getElementById('filter-form').submit();">
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4 max-height-vh-70">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 w-10">No Antrian
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 w-20">Supplier
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 w-20">Nama Barang
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-20">Aksi
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-10">Status
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-20">
                                Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $supplyRowspanCounter = [];
                            foreach ($flatData as $item) {
                                $id = $item['supply']->id;
                                if (!isset($supplyRowspanCounter[$id])) {
                                    $supplyRowspanCounter[$id] = 0;
                                }
                                $supplyRowspanCounter[$id]++;
                            }
                            $printed = [];
                        @endphp

                        @foreach ($flatData as $item)
                            @php
                                $supply = $item['supply'];
                                $barang = $item['barang'];
                            @endphp
                            <tr>
                                @if (!in_array($supply->id, $printed))
                                    <td class="py-3" rowspan="{{ $supplyRowspanCounter[$supply->id] }}">
                                        <p class="px-5 font-weight-bold mb-0">{{ $supply->no_antrian }}</p>
                                    </td>
                                    <td class="py-3" rowspan="{{ $supplyRowspanCounter[$supply->id] }}">
                                        <p class="font-weight-bold mb-0">{{ $supply->nama_perusahaan }}</p>
                                    </td>
                                    @php
                                        $printed[] = $supply->id;
                                    @endphp
                                @endif
                                <td class="py-3">
                                    <p class="font-weight-bold mb-0 mx-3">{{ $barang->nama_barang }}</p>
                                </td>
                                <td class="py-3 d-flex gap-3 px-0">
                                    <button type="button" class="btn btn-outline-primary">Panggil</button>
                                    <button type="button" class="btn btn-outline-success px-4">Hasil</button>
                                </td>
                                <td class="py-3">
                                    <p class="font-weight-bold mb-0">
                                        @if ($barang->status)
                                            {{ $barang->status }}
                                        @else
                                            <span class="fst-italic opacity-7">Belum ada status.</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="py-3">
                                    <p class="font-weight-bold mb-0">
                                        @if ($barang->keterangan)
                                            {{ $barang->keterangan }}
                                        @else
                                            <span class="fst-italic opacity-7">Tanpa keterangan.</span>
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection