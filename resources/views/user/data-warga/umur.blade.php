@extends('layouts.user')
@section('title', 'Data Umur')

@push('styles')
    @vite('resources/css/datawarga.css')
@endpush

@section('content')
<div class="dw-wrap">

    <div class="dw-header">
        <div class="dw-title-row">
            <div class="dw-title-bar"></div>
            <h1 class="dw-title">Kelompok Umur Kelurahan Batu Besar</h1>
        </div>
        <p class="dw-subtitle">Sebaran kelompok usia penduduk per RW/RT.</p>
    </div>

    @php
        $kelompokKeys   = ['0-5','6-12','13-17','18-30','31-50','>50'];
        $kelompokLabels = ['0–5 th','6–12 th','13–17 th','18–30 th','31–50 th','> 50 th'];
        $kelompokColors = ['#2486d9','#1fa050','#f0a500','#7c3aed','#e84393','#0891b2'];
    @endphp

    <div class="dw-jumlah-layout">

        {{-- KIRI --}}
        <div class="dw-jumlah-left">

            {{-- Kartu ringkasan per kelompok --}}
            <div class="dw-summary-cards" style="grid-template-columns:repeat(3,1fr)">
                @foreach($kelompokKeys as $idx => $key)
                <div class="dw-summary-item" style="background:{{ $kelompokColors[$idx] }}">
                    <div class="dw-summary-icon">👤</div>
                    <div class="dw-summary-val">{{ number_format($kelompokUmur[$key] ?? 0) }}</div>
                    <div class="dw-summary-label">{{ $kelompokLabels[$idx] }}</div>
                </div>
                @endforeach
            </div>

            {{-- Accordion per RW --}}
            <div class="dw-accordion-wrap">
                @for($i = 1; $i <= 23; $i++)
                @php
                    $nomorRw = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $rtData  = $perRw[$nomorRw] ?? [];
                    $rwTotal = 0;
                    foreach($rtData as $umur) {
                        foreach($kelompokKeys as $k) $rwTotal += ($umur[$k] ?? 0);
                    }
                @endphp
                <details class="dw-accordion">
                    <summary class="dw-accordion-summary">
                        <div class="dw-acc-left">
                            <span class="dw-acc-badge">RW {{ $nomorRw }}</span>
                            <span class="dw-acc-count">{{ count($rtData) }} RT</span>
                        </div>
                        <span class="dw-acc-total">{{ $rwTotal }} jiwa</span>
                    </summary>
                    <div class="dw-accordion-body">
                        @if(count($rtData) > 0)
                        <div style="overflow-x:auto">
                        <table class="dw-table" style="min-width:500px">
                            <thead>
                                <tr>
                                    <th>No</th><th>RT</th>
                                    @foreach($kelompokLabels as $lbl)
                                    <th>{{ $lbl }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rtData as $rt => $umur)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>RT {{ $rt }}</td>
                                    @foreach($kelompokKeys as $k)
                                    <td>{{ $umur[$k] ?? 0 }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @else
                        <p class="dw-empty">Belum ada data untuk RW ini.</p>
                        @endif
                    </div>
                </details>
                @endfor
            </div>

        </div>

        {{-- KANAN: Diagram --}}
        <div class="dw-jumlah-right">
            <div class="dw-chart-card">
                <h3 class="dw-chart-title">Sebaran Kelompok Umur</h3>
                <div class="dw-chart-wrap">
                    <canvas id="chartUmur"></canvas>
                </div>
                <div class="dw-chart-legend" style="flex-wrap:wrap;gap:8px;justify-content:flex-start;margin-top:12px">
                    @foreach($kelompokLabels as $idx => $lbl)
                    <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;color:#6a8a72">
                        <span class="dw-legend-dot" style="background:{{ $kelompokColors[$idx] }}"></span>
                        {{ $lbl }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const umurLabels = @json($kelompokLabels);
const umurValues = @json(array_values(array_map(fn($k) => $kelompokUmur[$k] ?? 0, $kelompokKeys)));
const umurColors = @json($kelompokColors);

new Chart(document.getElementById('chartUmur'), {
    type: 'doughnut',
    data: {
        labels: umurLabels,
        datasets: [{
            data: umurValues,
            backgroundColor: umurColors,
            borderWidth: 0,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '55%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed.toLocaleString('id-ID')} orang` } }
        }
    }
});
</script>
@endsection
