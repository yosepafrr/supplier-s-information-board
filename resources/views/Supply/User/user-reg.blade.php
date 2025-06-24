@extends('layout')

@section('konten')

    <div class="mt-2 mx-4">
        @if (session('success'))
            <div class="alert alert-success text-white show" role="alert" id="success-alert">
                <strong>Registrasi berhasil !</strong> Anda bisa memantau tiket anda di bagian monitoring untuk user.
            </div>

            <script>
                setTimeout(() => {
                    const alertBox = document.getElementById('success-alert');
                    if (alertBox) {
                        alertBox.classList.remove('show');
                        alertBox.classList.add('fade');
                        setTimeout(() => alertBox.remove(), 300); // remove element after fade out
                    }
                }, 7000);
            </script>
        @endif

        <h1 class="h4 font-weight-bold mb-0">REGISTRASI PENGAMBILAN TIKET</h1>
        <p>Silahkan isi data-data dibawah.</p>

        <div class="bg-white h-screen w-full card p-3">
            <form action="{{ route('supply.user.submit') }}" method="POST">
                @csrf
                <h5 class="h5 mt-2">Driver</h5>
                <div class="input-group input-group-lg input-group-outline mb-3">
                    <label class="form-label">Nama Driver</label>
                    <input type="text" name="nama_driver" class="form-control form-control-lg">
                </div>
                <div class="input-group input-group-lg input-group-outline my-3">
                    <label class="form-label">Nomor Polisi</label>
                    <input type="text" name="nopol" class="form-control form-control-lg">
                </div>
                <div class="input-group input-group-lg input-group-outline my-3">
                    <label class="form-label">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" class="form-control form-control-lg">
                </div>
                <h5 class="h5 mt-2">Barang</h5>
                <div class="input-group input-group-lg input-group-outline mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control form-control-lg">
                </div>
                <div class="input-group input-group-lg input-group-outline my-3">
                    <label class="form-label">Jumlah Barang</label>
                    <input type="text" name="jumlah_barang" class="form-control form-control-lg">
                </div>
                {{-- MODAL MAKE SURE --}}
                <div class="col-md-4">
                    <button type="button" class="btn btn-outline-primary bg-gradient-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#modal-default">Submit</button>
                    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default"
                        aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title font-weight-normal" id="modal-title-default">Apakah data sudah
                                        benar?</h6>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary my-3" data-bs-toggle="modal"
                                        data-bs-target="#modal-default">Ya</button>
                                    <button type="button" class="btn btn-link mt-3  ml-auto"
                                        data-bs-dismiss="modal">Kembali</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- MODAL MAKE SURE --}}
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.querySelector('form');

                    form.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                        }
                    });
                });
            </script>

        </div>
    </div>
@endsection