@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <h1 class="h4 font-weight-bold mb-0">Monitoring Antrian Barang</h1>
        <p>Silahkan isi data-data dibawah.</p>
        <div class="card">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 ps-2">Supplier
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                Nama Barang</th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplies as $supply)
                            @foreach ($supply->barangs as $index => $barang)
                                <tr>
                                    @if ($index === 0)
                                        <td class="py-3" rowspan="{{ $supply->barangs->count() }}">
                                            <p class="text-xs  px-3 font-weight-bold mb-0">{{ $supply->no_antrian }}</p>
                                        </td>
                                        <td class="py-3" rowspan="{{ $supply->barangs->count() }}">
                                            <p class="text-xs font-weight-bold mb-0">{{ $supply->nama_perusahaan }}</p>
                                        </td>
                                    @endif
                                    <td class="py-3">
                                        <p class="text-xs font-weight-bold mb-0 mx-3">{{ $barang->nama_barang }}</p>
                                    </td>
                                    <td class="py-3">
                                        <p class="text-xs font-weight-bold mb-0 mx-3">{{ $supply->no_antrian }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection