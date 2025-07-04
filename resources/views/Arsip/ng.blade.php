@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Arsip Barang - Not Good (NG)</h1>
            </div>
            <div>
                <form method="GET" action="{{ route('arsip.ng') }}" id="filter-form">
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
                            <th class="text-uppercase text-xxs text-secondary px-3 mx-3 font-weight-bolder opacity-7 w-5">
                                Tanggal Antrian Masuk
                            </th>
                            <th class="text-uppercase text-xxs text-secondary px-2 mx-3 font-weight-bolder opacity-7 w-5">
                                Jam Antrian Masuk
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-9">Tanggal
                                Update QC
                            </th>
                            <th class="text-uppercase text-xxs text-secondary px-0 font-weight-bolder opacity-7 w-8">Nama
                                Driver
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-6 px-0">Nomor
                                Polisi
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-10 px-0">Nama
                                Supplier
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 w-10 px-0">Nama Barang
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-8">Jumlah
                                Barang
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-20 px-1">Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arsip as $index => $data)
                            <tr>
                                <td class="p-3">
                                    <p class="font-weight-bold mb-0">
                                        {{ $data->tanggal_masuk }}</p>
                                </td>
                                <td class="py-3">
                                    <p class="font-weight-bold mb-0">
                                        {{ $data->jam_masuk }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <p class="font-weight-bold mb-0">
                                        {{ \Carbon\Carbon::parse($data->tanggal_update_qc)->format('d-m-Y H:i') }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <p class="font-weight-bold mb-0">{{ $data->nama_driver }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <p class="font-weight-bold mb-0">{{ $data->nopol }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <p class="font-weight-bold mb-0">{{ $data->nama_perusahaan }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <p class="font-weight-bold mb-0">{{ $data->nama_barang }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <p class="font-weight-bold mb-0">{{ $data->jumlah_barang }}</p>
                                </td>
                                <td class="py-3 px-1">
                                    <p class="font-weight-bold mb-0">{{ $data->keterangan }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection