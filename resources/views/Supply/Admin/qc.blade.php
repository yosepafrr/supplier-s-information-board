@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div id="alert-container" class="top-0 w-100"></div>

        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Admin Quality Control</h1>
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
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 w-5">Antrian
                            </th>
                            <th class="text-uppercase text-xxs text-secondary px-2 mx-3 font-weight-bolder opacity-7 w-15">
                                Supplier
                            </th>
                            <th class="text-uppercase text-xxs text-secondary px-0 font-weight-bolder opacity-7 w-10">Nama
                                Driver
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 w-10">Nama Barang
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-20">Aksi
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-10">Status
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
                                        <p class="font-weight-bold mb-0" style="padding-left: 1.5rem;">{{ $supply->no_antrian }}</p>
                                    </td>
                                    <td class="py-3 px-" rowspan="{{ $supplyRowspanCounter[$supply->id] }}">
                                        <p class="font-weight-bold mb-0">{{ $supply->nama_perusahaan }}</p>
                                    </td>
                                    <td class="py-3 px-0" rowspan="{{ $supplyRowspanCounter[$supply->id] }}">
                                        <p class="font-weight-bold mb-0">{{ $supply->nama_driver }}</p>
                                    </td>
                                    @php
                                        $printed[] = $supply->id;
                                    @endphp
                                @endif
                                <td class="py-3">
                                    <p class="font-weight-bold mb-0 mx-3">{{ $barang->nama_barang }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        onclick="showDetail({{ $barang->id }}, '{{ e($barang->nama_barang) }}', '{{ e($barang->jumlah_barang) }}', '{{ e($supply->nama_perusahaan) }}', '{{ e($supply->nama_driver) }}', '{{ e($supply->nopol) }}', '{{ e($supply->no_antrian) }}', '{{ e($supply->jam) }}', '{{ e($supply->tanggal) }}')">
                                        Detail Informasi
                                    </button>
                                    <button style="margin-left: 5px;" type="button" class="btn btn-outline-success px-4"
                                        data-bs-toggle="modal" data-bs-target="#hasilModal" data-barang-id="{{ $barang->id }}"
                                        onclick="setBarangId(this)">
                                        Hasil
                                    </button>
                                    <button style="margin-left: 5px;" type="button" class="btn btn-outline-primary"
                                        onclick="panggilBarang({{ $barang->id }}, '{{ e($barang->nama_barang) }}', '{{ e($supply->nama_perusahaan) }}', '{{ e($supply->nama_driver) }}', '{{ e($supply->no_antrian) }}')">Panggil</button>
                                </td>
                                <td class="py-3 px-4">
                                    <p class="font-weight-bold mb-0">
                                        @if ($barang->status)
                                            {{ $barang->status }}
                                        @else
                                            <span class="fst-italic opacity-7">Belum ada status.</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="py-3"
                                    style="max-width: 6.25rem; word-wrap: break-word; white-space: normal;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ">
                                    <p class="font-weight-bold mb-0">
                                        @if ($barang->keterangan)
                                            {{ $barang->keterangan }}
                                        @else
                                            <span class="fst-italic opacity-7">Tanpa catatan.</span>
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


    {{-- MODAL HASIL --}}
    <div class="modal fade" id="hasilModal" tabindex="-1" aria-labelledby="hasilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-success">
                <div class="modal-header">
                    <h5 class="modal-title" id="hasilModalLabel">Pilih Aksi Hasil</h5>
                    <button type="button" class="btn-close text-dark mb" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center d-flex justify-content-center">
                    <form id="hasilForm" method="POST" action="{{ route('supply.admin.qc.updateStatus') }}">
                        @csrf
                        <input type="hidden" name="barang_id" id="hasilModal-barang-id">
                        <button type="submit" name="status" value="Ok" class="btn btn-success m-2">OK</button>
                    </form>
                    <div class="mt-2">
                        <button type="button" class="btn btn-danger" onclick="confirmCatatanFromModal('Not Good')"
                            data-bs-dismiss="modal">Not Good</button>

                        <button type="button" class="btn btn-warning mx-1" onclick="confirmCatatanFromModal('Hold')"
                            data-bs-dismiss="modal">Hold</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL JIKA HASIL NG ATAU HOLD APAKAH INGIN MENAMBAHKAN CATATAN? --}}
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('supply.admin.qc.updateStatus') }}">
                @csrf
                <input type="hidden" name="barang_id" id="konfirmasiModal-barang-id">
                <input type="hidden" name="status" id="modal-status">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambahkan Catatan?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda ingin menambahkan catatan?</p>
                        <div class="input-group input-group-dynamic mb-4 d-none" id="input-catatan-wrapper">
                            <textarea class="form-control" name="catatan" id="catatan" placeholder="Ketik catatan disini"
                                aria-label="Username" aria-describedby="basic-addon1" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="skipCatatan()">Tidak</button>
                        <button type="button" class="btn btn-primary" onclick="showCatatanInput()">Ya</button>
                        <button type="submit" class="btn btn-success d-none" id="submit-catatan-btn">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- MODAL JIKA HASIL NG ATAU HOLD APAKAH INGIN MENAMBAHKAN CATATAN? --}}
    {{-- MODAL HASIL --}}


    {{-- MODAL FIELD CATATAN JIKA INGIN MENAMBAHKAN CATATAN --}}
    <script>
        let currentBarangId = null;

        function setBarangId(button) {
            const barangId = button.getAttribute('data-barang-id');
            document.getElementById('hasilModal-barang-id').value = barangId;
            currentBarangId = barangId; // simpan untuk modal catatan
        }


        // logic modal catatan
        let selectedId = null;
        let selectedStatus = null;

        function confirmCatatanFromModal(status) {
            if (!currentBarangId) {
                alert('ID tidak ditemukan.');
                return;
            }

            document.getElementById('konfirmasiModal-barang-id').value = currentBarangId;
            document.getElementById('modal-status').value = status;
            document.getElementById('input-catatan-wrapper').classList.add('d-none');
            document.getElementById('submit-catatan-btn').classList.add('d-none');

            const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
            modal.show();
        }

        function showCatatanInput() {
            document.getElementById('input-catatan-wrapper').classList.remove('d-none');
            document.getElementById('submit-catatan-btn').classList.remove('d-none');
        }

        function skipCatatan() {
            // langsung kirim form tanpa catatan
            document.getElementById('catatan').value = '';
            document.querySelector('#modalKonfirmasi form').submit();

        }
    </script>
    {{-- MODAL FIELD CATATAN JIKA INGIN MENAMBAHKAN CATATAN --}}


    <!-- MODAL DETAIL INFORMASI -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Detail Informasi</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class=" mb-0 py-1"><strong>Nomor Antrian:</strong><span id="detail-nomor-antrian"
                            class="mx-2"></span>
                    </p>
                    <p class=" mb-0 py-1"><strong>Jam Masuk:</strong><span id="detail-jam-masuk" class="mx-2"></span></p>
                    <p class=" mb-0 py-1"><strong>Tanggal Masuk:</strong><span id="detail-tanggal-masuk"
                            class="mx-2"></span></p>
                    <p class="mt-3 mb-0 py-1"><strong>Nama Supplier:</strong><span id="detail-supplier" class="mx-2"></span>
                    </p>
                    <p class=" mb-0 py-1"><strong>Nama Driver:</strong><span id="detail-driver" class="mx-2"></span></p>
                    <p class=" mb-0 py-1"><strong>Nomor Polisi:</strong><span id="detail-nopol" class="mx-2"></span></p>
                    <p class="mt-3 mb-0 py-1"><strong>Nama Barang:</strong><span id="detail-nama-barang"
                            class="mx-2"></span>
                    </p>
                    <p class=" mb-0 py-1"><strong>Jumlah Barang:</strong><span id="detail-jumlah-barang"
                            class="mx-2"></span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(id, namaBarang, jumlahBarang, supplier, driver, nopol, antrian, jam, tanggal) {
            document.getElementById('detail-nomor-antrian').innerText = antrian;
            document.getElementById('detail-jam-masuk').innerText = jam;
            document.getElementById('detail-tanggal-masuk').innerText = tanggal;
            document.getElementById('detail-nama-barang').innerText = namaBarang;
            document.getElementById('detail-jumlah-barang').innerText = jumlahBarang;
            document.getElementById('detail-supplier').innerText = supplier;
            document.getElementById('detail-driver').innerText = driver;
            document.getElementById('detail-nopol').innerText = nopol;
        }
    </script>
    {{-- MODAL DETAIL INFORMASI --}}


    <!-- MODAL KONFIRMASI PANGGILAN -->
    <div class="modal fade" id="modalKonfirmasiPanggilan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">Konfirmasi Panggilan</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <p id="pesanKonfirmasiPanggilan">Apakah Anda yakin ingin memanggil barang ini?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnKonfirmasiPanggil">Panggil</button>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL MAKE SURE PEMANGGILAN --}}
    <script>
        let barangIdTerpilih = null;
        let namaBarangTerpilih = null;

        function panggilBarang(barangId, namaBarang, supplier, driver, noAntrian) {
            barangIdTerpilih = barangId;
            namaBarangTerpilih = namaBarang;
            namaSupplier = supplier;
            namaDriver = driver;
            nomorAntrian = noAntrian;

            // Set pesan di modal
            document.getElementById('pesanKonfirmasiPanggilan').innerText =
                `Apakah Anda yakin ingin memanggil: 
                                Driver ${driver} 
                                Dengan barang ${namaBarang} 
                                Dari ${supplier}?`;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasiPanggilan'));
            modal.show();
        }

        document.getElementById('btnKonfirmasiPanggil').addEventListener('click', () => {
            fetch('{{ route('admin.qc.panggilan.panggil') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    barang_id: barangIdTerpilih,
                    dari: 'QC',
                    pesan: `No Antrian ${nomorAntrian} 
                            ${namaBarangTerpilih} dari ${namaSupplier} oleh ${namaDriver}
                            Silahkan menuju counter QC` // Pesan panggilan
                })
            })
                .then(response => response.json())
                .then(data => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalKonfirmasiPanggilan'));
                    modal.hide();

                    if (data.success) {
                        showBootstrapAlert('success', 'Panggilan berhasil dibuat!');
                    } else {
                        showBootstrapAlert('danger', 'Terjadi kesalahan saat memanggil.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showBootstrapAlert('danger', 'Terjadi kesalahan saat memanggil.');
                });
        });
    </script>
    {{-- MODAL MAKE SURE PEMANGGILAN --}}

    {{-- ALERT STATUS PEMANGGILAN --}}
    <script>
        function showBootstrapAlert(type, message, timeout = 5000) {
            const alertId = `alert-${Date.now()}`;

            const alertHTML = `
                                    <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show text-white" role="alert">
                                        <strong>${message}</strong>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    `;

            const container = document.getElementById('alert-container');
            container.insertAdjacentHTML('beforeend', alertHTML);

            setTimeout(() => {
                const alertBox = document.getElementById(alertId);
                if (alertBox) {
                    alertBox.classList.remove('show');
                    alertBox.classList.add('fade');
                    setTimeout(() => alertBox.remove(), 300); // Remove after fade out
                }
            }, timeout);
        }
    </script>
    {{-- ALERT STATUS PEMANGGILAN --}}



@endsection