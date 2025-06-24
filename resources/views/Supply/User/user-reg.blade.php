@extends('layout')

@section('konten')

    <div class="mt-2 mx-4">

        {{-- ALERT --}}
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
        @if (session('error'))
            <div class="alert alert-danger text-white show" role="alert" id="success-alert">
                <strong>Registrasi Gagal!</strong> Lengkapi form registrasi untuk menghindari gagal.
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
        {{-- ALERT --}}

        <h1 class="h4 font-weight-bold mb-0">REGISTRASI PENGAMBILAN TIKET</h1>
        <p>Silahkan isi data-data dibawah.</p>

        <div class="bg-white h-screen w-full card p-3">
            <form action="{{ route('supply.user.submit') }}" method="POST">
                @csrf

                {{-- FORM DRIVER --}}

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

                {{-- FORM DRIVER --}}


                {{-- FORM BARANG --}}
                <div id="barang-container">
                    <h5 class="h5 mt-2">Barang 1</h5>
                    <div class="input-group input-group-lg input-group-outline mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="barang[0][nama_barang]" class="form-control form-control-lg">
                    </div>
                    <div class="input-group input-group-lg input-group-outline my-3">
                        <label class="form-label">Jumlah Barang</label>
                        <input type="text" name="barang[0][jumlah_barang]" class="form-control form-control-lg">
                    </div>
                </div>
                <button type="button" class="btn btn-outline-success" id="tambah-barang">+ Tambah Barang</button>
                {{-- FORM BARANG --}}

                {{-- MAKE SURE MODAL --}}
                <div class="col-md-4">
                    <button type="button" class="btn btn-outline-primary w-100 mb-3" data-bs-toggle="modal"
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
                {{-- MAKE SURE MODAL --}}

            </form>

            {{-- FUNGSI UNTUK MENCEGAH ENTER MELAKUKAN SUBMIT --}}
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
            {{-- FUNGSI UNTUK MENCEGAH ENTER MELAKUKAN SUBMIT --}}


            {{-- FUNGSI TAMBAH FORM BARANG --}}
            <script>
                let index = 1;

                document.getElementById('tambah-barang').addEventListener('click', () => {
                    const container = document.getElementById('barang-container');

                    const row = document.createElement('div');
                    row.classList.add('barang-row', 'mb-2');

                    row.innerHTML = `
                                        <div class="barang-form-grup">
                                            <h5 class="h5 mt-2">Barang ${index + 1}</h5>
                                            <div class="input-group input-group-lg input-group-outline mb-3">
                                                <label class="form-label">Nama Barang</label>
                                                <input type="text" name="barang[${index}][nama_barang]" class="form-control form-control-lg">
                                            </div>
                                            <div class="input-group input-group-lg input-group-outline my-3">
                                                <label class="form-label">Jumlah Barang</label>
                                                <input type="text" name="barang[${index}][jumlah_barang]" class="form-control form-control-lg">
                                            </div>
                                        </div>
                                    `;

                    container.appendChild(row);

                    // WAJIB: Trigger blur agar floating label naik
                    const inputs = row.querySelectorAll('input');

                    inputs.forEach(input => {
                        // trigger blur agar floating label naik jika kosong
                        input.addEventListener('focus', function () {
                            input.parentElement.classList.add('is-focused');
                        });

                        input.addEventListener('blur', function () {
                            input.parentElement.classList.remove('is-focused');

                            if (input.value.trim() !== '') {
                                input.parentElement.classList.add('is-filled');
                            } else {
                                input.parentElement.classList.remove('is-filled');
                            }
                        });

                        // Jika sudah punya value saat ditambahkan, langsung naikkan label
                        if (input.value.trim() !== '') {
                            input.parentElement.classList.add('is-filled');
                        }
                    });

                    index++;
                });
            </script>
            {{-- FUNGSI TAMBAH FORM BARANG --}}

            <script>

            </script>

        </div>
    </div>
@endsection