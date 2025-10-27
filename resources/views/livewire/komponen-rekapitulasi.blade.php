<div class="card">
    @php

    @endphp
    
    {{-- Be like water. --}}
    <div class="px-3 py-2">
        <div class="d-flex justify-content-between gap-3 mt-3">
            {{-- LINE CHART --}}
            <div class="card z-index-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="">Grafik Data Barang</h5>
                    <form method="GET" action="{{ route('rekapitulasi') }}">
                            <div class="input-group input-group-outline" style="width: 300px;">
                                <select name="range" onchange="this.form.submit()" class="form-control" required>
                                    <option disabled selected>Range Waktu</option>
                                    <option value="7"  {{ $range == 7}}>1 Minggu</option>
                                    <option value="14" {{ $range == 14}}>2 Minggu</option>
                                    <option value="30" {{ $range == 30}}>1 Bulan</option>
                                    <option value="90" {{ $range == 90}}>3 Bulan</option>                                
                                </select>
                            </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="statusLineChart" class="chart-canvas" style="width: 1300px; height:550px;"></canvas>
                    </div>
                </div>
            </div>
            {{-- LINE CHART --}}
            {{-- PIE CHART --}}
            <div class="card mb-4 flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Rekap Barang</h5>
                    <div>
                        <form method="GET" action="{{ route('rekapitulasi') }}" id="filter-form">
                            <div class="input-group input-group-outline my-3">
                                <input type="date" class="form-control" name="tanggal"
                                    value="{{ request('tanggal') ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    onchange="document.getElementById('filter-form').submit();">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">      
                    <canvas id="statusPieChart" style="width: 200px; height:500px;" class="mb-2"></canvas>
                    <span>Total Barang Pada {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d-m-Y') }}: <strong>{{ $counts['total'] ?? 0 }} Barang </strong></span>
                </div>
            </div>
            {{-- PIE SCRIPT --}}
        </div>
    </div>
</div>

{{-- PIE SCRIPT --}}
<script src="{{ asset('path/to/chartjs.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('statusPieChart').getContext('2d');

        // data dari backend (boleh dari Livewire, controller, etc.)
        const data = {
            labels: ['Ok', 'Not Good', 'Hold'],  // label status
            datasets: [{
                data: [
                    {{ $counts['ok'] ?? 0 }}, 
                    {{ $counts['not_good'] ?? 0 }}, 
                    {{ $counts['hold'] ?? 0 }}
                ],
                backgroundColor: [
                    '#a2bffe',     // biru untuk Ok
                    '#f44336',     // merah untuk Not Good
                    '#ff9800'      // oranye untuk Hold
                ],
                hoverOffset: 10
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                animation: { duration: 0 },
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.chart._metasets[0].total;
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }                
                }
            }
        };

        new Chart(ctx, config);
    });
</script>

{{-- LINE CHART SCRIPT --}}
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        const datasetsAll = {
            ok: {!! json_encode(array_column($dailyCounts, 'ok')) !!},
            not_good: {!! json_encode(array_column($dailyCounts, 'not_good')) !!},
            hold: {!! json_encode(array_column($dailyCounts, 'hold')) !!},
            tanpa_status: {!! json_encode(array_column($dailyCounts, 'tanpa_status')) !!},
            total: {!! json_encode(array_column($dailyCounts, 'total')) !!}
        };
        const ctx = document.getElementById('statusLineChart').getContext('2d');

        const labels = {!! json_encode(array_keys($dailyCounts)) !!};

        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Ok',
                    data: {!! json_encode(array_column($dailyCounts, 'ok')) !!},
                    borderColor: '#a2bffe',
                    backgroundColor: '#a2bffe',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Not Good',
                    data: {!! json_encode(array_column($dailyCounts, 'not_good')) !!},
                    borderColor: '#f44336',
                    backgroundColor: '#f44336',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Hold',
                    data: {!! json_encode(array_column($dailyCounts, 'hold')) !!},
                    borderColor: '#ff9800',
                    backgroundColor: '#ff9800',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Tanpa Status',
                    data: {!! json_encode(array_column($dailyCounts, 'tanpa_status')) !!},
                    borderColor: '#d3d3d3',
                    backgroundColor: '#d3d3d3',
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Total',
                    data: {!! json_encode(array_column($dailyCounts, 'total')) !!},
                    borderColor: '#4CAF50',
                    backgroundColor: '#4CAF50',
                    tension: 0.3,
                    fill: false
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                animation: {
                    duration: 0
                },
                interaction: {
                    mode: 'index',   // tooltip muncul per "index" (per hari, semua dataset)
                    intersect: false // biar gak harus tepat di titik
                },
                plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw;
                                },
                                title: function(context) {
                                    // Judul tooltip pakai tanggal (sumbu X)
                                    return 'Tanggal: ' + context[0].label;
                                }
                            }
                        },
                        legend: { position: 'bottom' }
                                            },
                        scales: {
                                x: { title: { display: true, text: 'Tanggal' } },
                                y: { beginAtZero: true, title: { display: true, text: 'Jumlah' } }
                            }            }
                                };

                                new Chart(ctx, config);
                        });
</script>
