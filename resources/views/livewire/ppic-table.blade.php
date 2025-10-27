            <div wire:poll.5s class="table-responsive">
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
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-10 px-2">Nomor Surat Jalan
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 w-10">Nama Barang
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-15">Aksi
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7  w-10">Status
                            </th>
                            <th class="text-uppercase text-xxs text-secondary font-weight-bolder opacity-7 px-0 w-10">
                                </th>
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
                                $isNew = $item['isNew'];
                            @endphp
                            <tr class="{{ $isNew ? 'highlight' : '' }}">
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
                                    <td class="py-3" style="max-width: 6.25rem; word-wrap: break-word; white-space: normal;" rowspan="{{ $supplyRowspanCounter[$supply->id] }}">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
                                        <p class="font-weight-bold mb-0">
                                            @if ($supply->no_surat_jalan)
                                                {{ $supply->no_surat_jalan }}
                                            @else
                                            <button type="button" class="btn btn-outline-secondary px-4"
                                            data-bs-toggle="modal" data-bs-target="#approveModal" data-barang-id="{{ $barang->id }}" data-supply-id="{{ $supply->id }}"
                                            onclick="setBarangId(this)">
                                            Input Nomor
                                            </button>    
                                            @endif
                                        </p>
                                        </td>    
                                    @php
                                        $printed[] = $supply->id;
                                    @endphp
                                @endif
                                <td class="py-3">
                                    <p class="font-weight-bold mb-0 mx-3">{{ $barang->nama_barang }}</p>
                                </td>
                                <td class="py-3 px-0">
                                    <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        onclick="showDetail({{ $barang->id }}, '{{ e($barang->nama_barang) }}', '{{ e($barang->jumlah_barang) }}', '{{ e($supply->nama_perusahaan) }}', '{{ e($supply->nama_driver) }}', '{{ e($supply->nopol) }}', '{{ e($supply->no_antrian) }}', '{{ e($supply->jam) }}', '{{ e($supply->tanggal) }}')">
                                        Detail Informasi
                                    </button>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#confirmApproveModal" onclick="bukaModalApprove({{ $barang->id }})">Approve</button>
                                </div>
                                </td>
                                <td class="py-3 px-4">
                                    <p class="font-weight-bold mb-0">
                                        @if ($barang->status_on_ppic)
                                            {{ $barang->status_on_ppic }}
                                        @else
                                            <span class="fst-italic opacity-7">Belum ada status.</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="py-3 px-0">
                                    <button type="button" class="btn btn-outline-danger w-80" onclick="panggilBarang({{ $barang->id }}, '{{ e($barang->nama_barang) }}', '{{ e($supply->nama_perusahaan) }}', '{{ e($supply->nama_driver) }}', '{{ e($supply->no_antrian) }}')">
                                        Panggil
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <script>
            document.addEventListener("DOMContentLoaded", () => {
                document.querySelectorAll("tr.highlight").forEach(row => {
                    row.classList.add("highlight");
                    setTimeout(() => {
                        row.classList.remove("highlight");
                    }, 100000);
                });
            });
            </script>