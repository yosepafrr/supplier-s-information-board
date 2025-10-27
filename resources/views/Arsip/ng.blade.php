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
                <livewire:arsip-ng-table />
                {{-- MODAL PREVIEW FOTO --}}
                    <div class="modal fade" id="PreviewImageModalNg" tabindex="-1" aria-hidden="true">
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
                {{-- MODAL PREVIEW FOTO --}}
            </div>
        </div>
    </div>
@endsection