@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div class="d-flex items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Monitoring Antrian Barang</h1>
                <p>Silahkan isi data-data dibawah.</p>
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
        <div class="card">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
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
                        @foreach ($supplies as $supply)
                            @foreach ($supply->barangs as $index => $barang)
                                <tr>
                                    @if ($index === 0)
                                        <td class="py-3" rowspan="{{ $supply->barangs->count() }}">
                                            <p class=" px-5 font-weight-bold mb-0">{{ $supply->no_antrian }}</p>
                                        </td>
                                        <td class="py-3" rowspan="{{ $supply->barangs->count() }}">
                                            <p class="font-weight-bold mb-0">{{ $supply->nama_perusahaan }}</p>
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