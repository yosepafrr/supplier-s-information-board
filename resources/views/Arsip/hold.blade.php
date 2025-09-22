@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Arsip Barang - Hold</h1>
            </div>
            <div>
                <form method="GET" action="{{ route('arsip.hold') }}" id="filter-form">
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
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-15 px-1">Keterangan
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-15 px-1">Foto Barang
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arsip as $index => $data)
                            <tr>
                                <td class="p-3">
                                    <p class="font-weight-bold mb-0">
                                        {{ $data->tanggal }}
                                    </p>
                                </td>
                                <td class="py-3">
                                    <p class="font-weight-bold mb-0">
                                        {{ $data->jam }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <p class="font-weight-bold mb-0">
                                        {{ \Carbon\Carbon::parse($data->status_qc_updated_at)->format('d-m-Y H:i') }}</p>
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
                                <td class="py-3 px-0">
                                    @php
                                        $fotos = json_decode($data->foto_barang, true);
                                    @endphp

                                    @if (!empty($fotos))
                                        @foreach ($fotos as $foto)
                                            <img src="{{ asset('storage/' . $foto) }}"
                                                alt="Foto Barang"
                                                class="img-thumbnail m-1 cursor-pointer"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @endforeach
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- MODAL PREVIEW FOTO --}}
                    <div class="modal fade" id="PreviewImageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content text-gray-800">
                        <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                            <span>Preview Foto</span>
                            <i class="material-symbols-rounded cursor-pointer end-0 text-2xl" data-bs-dismiss="modal" aria-label="Close">close</i>
                        </div>

                        <!-- Pindahkan ke modal-body -->
                        <div class="modal-body text-center position-relative pt-0">
                            <img alt="Preview" class="img-fluid rounded w-100" id="modalImg">
                        </div>
                        </div>
                    </div>
                    </div>
                {{-- MODAL PREVIEW FOTO --}}

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('img');
            const modalImg = document.getElementById('modalImg');
            
            images.forEach(image => {
                image.setAttribute('data-bs-toggle', 'modal');
                image.setAttribute('data-bs-target', '#PreviewImageModal');

                image.addEventListener('click', () => {
                    modalImg.src = image.src;
                    PreviewImageModal.show();
                });
            });
        })
    </script>

@endsection