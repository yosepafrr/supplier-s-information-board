            <div>
            @foreach ($batches as $batchIndex => $batch)
                <div
                    class="d-flex flex-wrap batch-view mb-4 position-absolute top-0 start-0 w-100 {{ $loop->first ? 'active' : 'hidden' }}">
                    @php
                        $printed = [];
                    @endphp
                    @foreach ($batch as $index => $item)
                        @php
                            $supply = $item['supply'];
                            $barang = $item['barang'];
                            $isFirst = !in_array($supply->id, $printed);
                            if ($isFirst)
                                $printed[] = $supply->id;
                        @endphp

                        @if ($loop->index < 2)
                            <div class="p-2 w-50">
                                <div class="card border-success mb-3 h-100">
                                    <div class="card-header bg-transparent border-success">
                                        <span class="text-2xl">Antrian {{ $supply->no_antrian }}</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-title text-6xl my-0 text-bold text-success">{{ $supply->nama_perusahaan }}</p>
                                        <p class="card-title text-4xl text-bold">{{ $supply->nama_driver }} | {{ $supply->nopol}}
                                        </p>
                                        <p class="card-text text-2xl">{{ $barang->nama_barang }} | {{ $barang->jumlah_barang }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-success">
                                        @if ($barang->progress_status)
                                            {{ $barang->progress_status }}
                                        @else
                                            <span>On Progress QC</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="p-2" style="width: 25%;">
                                <div class="card border-secondary mb-3 h-100">
                                    <div class="card-header bg-transparent border-success">
                                        Antrian {{ $supply->no_antrian }}
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-2xl text-success my-0">{{ $supply->nama_perusahaan }}</h5>
                                        <p class="card-title text-md text-bold">{{ $supply->nama_driver }} | {{ $supply->nopol}}
                                        </p>
                                        <p class="card-text text-sm">{{ $barang->nama_barang }} | {{ $barang->jumlah_barang }}</p>

                                    </div>
                                    <div class="card-footer bg-transparent border-success">
                                        @if ($barang->progress_status)
                                            {{ $barang->progress_status }}
                                        @else
                                            <span>On Progress QC</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            
