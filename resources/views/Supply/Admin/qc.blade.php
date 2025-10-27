@extends('layout')

@section('konten')
    <div class="mt-2 mx-5">
        <div id="alert-container" class="top-0 w-100"></div>

        {{-- ALERT NOTIFIKASI --}}
        <div id="notifAlert" class="alert-success alert-dismissible fade position-fixed top-0 end-0 m-3 d-none" role="alert"
            style="z-index: 9999; min-width: 400px; max-height: 200px;">
            <span id="notifAlertMessage" class="text-white mt-1">Pesan notifikasi</span>
            <button type="button" class="btn-close" style="margin-top: -5px" onclick="hideNotif()" aria-label="Close">x</button>
        </div>
        {{-- ALERT NOTIFICATION --}}



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
                <livewire:qc-table />
                {{-- MODAL PREVIEW FOTO --}}
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content text-gray-800">
                        <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                            <span>Preview Foto</span>
                            <i class="material-symbols-rounded cursor-pointer end-0 text-2xl">close</i>
                        </div>

                        <!-- Pindahkan ke modal-body -->
                        <div class="modal-body text-center position-relative pt-0">
                            <img alt="Preview" class="img-fluid rounded w-100" id="modalImg">
                        </div>
                        </div>
                    </div>
                    </div>
                {{-- MODAL PREVIEW FOTO --}}
                    {{-- MODAL PREVIEW FOTO PADA TABEL --}}
                    <div class="modal fade" id="PreviewImageModalQc" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content text-gray-800">
                        <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                            <span>Preview Foto</span>
                            <i class="material-symbols-rounded cursor-pointer end-0 text-2xl" data-bs-dismiss="modal" aria-label="Close">close</i>
                        </div>

                        <!-- Pindahkan ke modal-body -->
                        <div class="modal-body text-center position-relative pt-0">
                            <img alt="Preview" class="img-fluid rounded w-100" id="modalImgPreview">
                        </div>
                        </div>
                    </div>
                {{-- MODAL PREVIEW FOTO PADA TABEL --}}

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

    {{-- MODAL JIKA HASIL NG ATAU HOLD APAKAH INGIN MENAMBAHKAN CATATAN DAN FOTO BARANG --}}
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('supply.admin.qc.updateStatus') }}">
                @csrf
                <input type="hidden" name="barang_id" id="konfirmasiModal-barang-id">
                <input type="hidden" name="status" id="modal-status">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambahkan Catatan dan Foto Barang?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda ingin menambahkan catatan dan foto barang?</p>
                        <div class="input-group input-group-dynamic mb-4 d-none" id="input-catatan-wrapper">
                            <textarea class="form-control" name="catatan" id="catatan" placeholder="Ketik catatan disini"
                                aria-label="Username" aria-describedby="basic-addon1" rows="3"></textarea>
                        </div>

                        {{-- Input foto --}}
                        <div class="mb-3 d-none" id="foto-upload-wrapper">
                            <label for="foto">Ambil Foto Barang</label>
                            <div class="d-flex flex-grow-row">
                                <div class="position-relative" style="display:inline-block;">
                                    <video id="video" width="640" height="480" autoplay></video>
                                    <button type="button" class="btn position-absolute bottom-0 p-3  start-50 translate-middle-x mb-5" id="capture" style="border-radius: 16rem; background: #404a6b;"><i class="material-symbols-rounded" style="font-size: 40px; color: white;">photo_camera</i></button>
                                </div>
                                <div class="ms-3">
                                    <canvas id="canvas" width="1440" height="1080" style="display: none;"></canvas>

                                    <div id="preview-container" class="mb-3"></div>
                                    <div id="input-container" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="skipCatatan()">Tanpa Catatan</button>
                        <button type="button" class="btn btn-primary" id="show-catatan-input-btn" onclick="showCatatanInput()">Ya</button>
                        <button type="submit" class="btn btn-success d-none" id="submit-catatan-btn">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- MODAL JIKA HASIL NG ATAU HOLD APAKAH INGIN MENAMBAHKAN CATATAN? --}}
    {{-- MODAL HASIL --}}


    {{-- MODAL FIELD CATATAN --}}
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
            document.getElementById('show-catatan-input-btn').classList.add('d-none');
            document.getElementById('foto-upload-wrapper').classList.remove('d-none');
            document.querySelector('#modalKonfirmasi .modal-content').style = 'width: 80vw; margin-left: -30vw;';
        }

            function skipCatatan() {
                // langsung kirim form tanpa catatan
                document.getElementById('catatan').value = '';
                document.querySelector('#modalKonfirmasi form').submit();

        }
    </script>
    {{-- MODAL FIELD CATATAN JIKA INGIN MENAMBAHKAN CATATAN --}}

    {{-- FUNGSI AMBIL GAMBAR VIA KAMERA --}}
        <script>
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const fotoInput = document.getElementById('fotoInput');
            const captureBtn = document.getElementById('capture');
            const previewContainer = document.getElementById('preview-container');
            const inputContainer = document.getElementById('input-container');
            
            
            const modalImg = document.getElementById('modalImg');
            const imageModal = document.getElementById('imageModal');


            // Minta izin akses kamera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Kamera tidak bisa di akses: ", err);
                })


            // Ambil gambar saat tombol ditekan
            captureBtn.addEventListener('click', () => {
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Konversi gambar ke format base64
                const dataUrl = canvas.toDataURL('image/png');

                const wrapper = document.createElement('div');
                wrapper.classList.add('position-relative', 'd-inline-block', 'me-2', 'mb-2');


                // Tampilkan preview
                const img = document.createElement('img');
                img.src = dataUrl;
                img.style = 'height: 236px; width: auto; cursor: pointer;';
                // document.getElementById('preview-container').appendChild(img);

                // cara Bootstrap native
                img.setAttribute('data-bs-toggle', 'modal');
                img.setAttribute('data-bs-target', '#imageModal');

                img.addEventListener('click', () => {
                    modalImg.src = dataUrl;
                    imageModal.show();
                });

                    const imageModalEl = document.getElementById('imageModal');

                    imageModalEl.addEventListener('shown.bs.modal', () => {
                        const handleClick = (e) => {
                            // Abaikan klik tombol close (biar tetap bisa nutup modal normal)
                            if (!e.target.closest('.btn-close')) {
                                const konfirmasiModal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
                                konfirmasiModal.show();

                                // Opsional: tutup imageModal setelah konfirmasi muncul
                                const imgModal = bootstrap.Modal.getInstance(imageModalEl);
                                imgModal.hide();

                                // Hapus listener biar tidak nambah-nambah
                                document.removeEventListener('click', handleClick);
                            }
                        };

                        // Tambahkan listener klik di seluruh layar
                        document.addEventListener('click', handleClick);
                    });

            // Tombol delete (akan menempel di pojok atas gambar)
                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute', 'top-0', 'end-0', 'm-1');
                delBtn.innerHTML = 'x'; // pakai icon kecil biar rapi
                delBtn.onclick = () => {
                    previewContainer.removeChild(wrapper);
                    inputContainer.removeChild(input);
                };

                // Input hidden
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'foto[]';
                input.value = dataUrl;

                // Susun
                wrapper.appendChild(img);
                wrapper.appendChild(delBtn);
                previewContainer.appendChild(wrapper);
                inputContainer.appendChild(input);

                canvas.classList.remove('d-none');            
            })

        </script>
    {{-- FUNGSI AMBIL GAMBAR VIA KAMERA --}}


    <!-- MODAL DETAIL INFORMASI -->
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
        let lastQcTime = localStorage.getItem("last_qc_check_time") || null;

        async function checkNewForQc() {
            try {
                const res = await fetch('/admin/qc/check-update');
                const data = await res.json();

                if (data.has_new && data.last_time !== lastQcTime) {
                    localStorage.setItem("last_qc_check_time", data.last_time);
                    lastQcTime = data.last_time;
                    showNotif('Ada data baru untuk Quality Control!', 'success');
                    // location.reload()
                }
            } catch (e) {
                console.error("Gagal cek data baru:", e);
            }
        }

        setInterval(checkNewForQc, 5000);
    </script>
    {{-- SCRIPT NOTIFICATION --}}


    {{-- SCRIPT MODAL PREVIEW BARANG --}}



@endsection