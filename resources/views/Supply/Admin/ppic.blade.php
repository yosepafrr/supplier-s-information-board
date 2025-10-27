@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
    <div id="alert-container" class="top-0 w-100"></div>

            {{-- ALERT NOTIFIKASI --}}
        <div id="notifAlert" class="alert-success alert-dismissible fade position-fixed top-0 end-0 m-3 d-none" role="alert"
            style="z-index: 9999; min-width: 400px; max-height: 200px;">
            <span id="notifAlertMessage" class="text-white mt-1">Pesan notifikasi</span>
            {{-- <button class="btn btn-outline-white ml-5rem my-2" type="button" onClick="window.location.reload();">Refresh
                Sekarang</button> --}}
            <button type="button" class="btn-close" style="margin-top: -5px;" onclick="hideNotif()" aria-label="Close">x</button>
        </div>
        {{-- ALERT NOTIFICATION --}}


        <div class="d-flex align-items-center justify-content-between w-full">
            <div>
                <h1 class="h4 font-weight-bold mb-0">Admin PPIC (Production Planning and Inventory Control)</h1>
            </div>
            <div>
                <form method="GET" action="{{ route('supply.admin.ppic') }}" id="filter-form">
                    <div class="input-group input-group-outline my-3">
                        <input type="date" class="form-control" name="tanggal"
                            value="{{ request('tanggal') ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                            onchange="document.getElementById('filter-form').submit();">
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4 max-height-vh-70">
            <livewire:ppic-table />
        </div>
    </div>


    {{-- MODAL NO SURAT JALAN --}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-success">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Masukan Nomor Surat Jalan</h5>
                    <button type="button" class="btn-close text-dark mb-2" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center d-flex justify-content-center">
                    <form id="approveForm" method="POST" action="{{ route('supply.admin.ppic.input-nsj') }}">
                        @csrf
                        <input type="hidden" name="barang_id" id="approveModal-barang-id">
                        <input type="hidden" name="supply_id" id="approveModal-supply-id"> {{-- Tambahan --}}

                        <div class="input-group input-group-outline my-3 w-100">
                            <label for="no_surat_jalan" class="form-label success">Nomor Surat Jalan</label>
                            <input type="text" name="no_surat_jalan" id="no_surat_jalan" class="form-control w-100"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function setBarangId(button) {
    const barangId = button.getAttribute('data-barang-id');
    const supplyId = button.getAttribute('data-supply-id');

    document.getElementById('approveModal-barang-id').value = barangId;
    document.getElementById('approveModal-supply-id').value = supplyId;

    // Kosongkan input nomor surat jalan agar selalu fresh
    document.getElementById('nomor-surat-jalan').value = '';

    currentBarangId = barangId;
}

    </script>
    {{-- MODAL NO SURAT JALAN --}}



    <!-- DETAIL MODAL -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                    <p class=" mb-0 py-1"><strong>Tanggal Masuk:</strong><span id="detail-tanggal-masuk" class="mx-2"></span></p>
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
    {{-- DETAIL MODAL --}}

            {{-- MODAL KONFIRMASI APPROVE (GLOBAL) --}}
            <script>
                function bukaModalApprove(barangId) {
                    document.getElementById('approve-barang-id').value = barangId;
                }
            </script>


            <div class="modal fade" id="confirmApproveModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title font-weight-normal text-white">Approve barang?</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('supply.admin.ppic.approve') }}">
                            @csrf
                            <input type="hidden" name="barang_id" id="approve-barang-id">
                            <div class="modal-body">
                                Approve barang ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Approve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- MODAL KONFIRMASI APPROVE (GLOBAL) --}}

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
    


    
        {{-- FUNGSI MAKE SURE PEMANGGILAN --}}
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
                fetch('{{ route('admin.ppic.panggilan.panggil') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        barang_id: barangIdTerpilih,
                        dari: 'PPIC',
                        pesan: `No Antrian ${nomorAntrian} 
                                ${namaBarangTerpilih} dari ${namaSupplier} oleh ${namaDriver}
                                Silahkan menuju counter PPIC` // Pesan panggilan
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
        {{-- FUNGSI MAKE SURE PEMANGGILAN --}}
    
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

            {{-- SCRIPT NOTIFICATION --}}
    <audio id="notifSound" src="{{ asset('assets/sound/bell.mp3') }}" preload="auto"></audio>
    <script>
        function showNotif(pesan, type = 'success') {
            const notif = document.getElementById('notifAlert');
            const message = document.getElementById('notifAlertMessage');
            const sound = document.getElementById('notifSound');

            // Set pesan dan tipe alert (success, danger, info, etc)
            message.textContent = pesan;
            notif.className = `alert alert-${type} alert-dismissible fade position-fixed top-0 end-0 m-3`; // reset classes
            notif.style.zIndex = 9999;

            notif.classList.remove('slide-out');
            notif.classList.add('d-none');

            setTimeout(() => {
                notif.classList.remove('d-none');
                notif.classList.add('slide-in');
            }, 10);

            // ⏯️ Mainkan suara
            if (sound) {
                sound.currentTime = 0; // mulai dari awal
                sound.play().catch((e) => {
                    console.warn('Gagal memutar suara:', e);
                });
            }
            // Auto hide setelah 15 detik
            setTimeout(() => {
                hideNotif();
            }, 5000);
        }

        function hideNotif() {
            const notif = document.getElementById('notifAlert');

            // Animasi fade-out
            notif.classList.remove('slide-in');
            notif.classList.add('slide-out');

            // Setelah transisi selesai, sembunyikan elemen
            setTimeout(() => {
                notif.classList.add('d-none');
            }, 300); // Bootstrap fade duration
        }
    </script>


    <script>
        let lastPpicTime = localStorage.getItem("last_ppic_check_time") || null;

        async function checkNewForPpic() {
            try {
                const res = await fetch('/admin/ppic/check-update');
                const data = await res.json();

                if (data.has_new && data.last_time !== lastPpicTime) {
                    localStorage.setItem("last_ppic_check_time", data.last_time);
                    lastPpicTime = data.last_time;
                    showNotif('Ada data baru untuk PPIC!', 'success');

                    // location.reload()
                }
            } catch (e) {
                console.error("Gagal cek data baru:", e);
            }
        }
        setInterval(checkNewForPpic, 5000);
    </script>

    {{-- SCRIPT NOTIFICATION --}}

    

@endsection