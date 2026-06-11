@extends('layouts.user')
@section('title', 'Data Pendidikan')

@push('styles')
    @vite('resources/css/datawarga.css')
@endpush

@section('content')
<div class="dw-wrap">

    <div class="dw-header">
        <div class="dw-title-row">
            <div class="dw-title-bar"></div>
            <h1 class="dw-title">Data Pendidikan Kelurahan Batu Besar</h1>
        </div>
        <p class="dw-subtitle">Sebaran tingkat pendidikan penduduk per RW/RT.</p>
    </div>

    <div class="dw-jumlah-layout">

        {{-- KIRI: Tabel ringkasan + Accordion --}}
        <div class="dw-jumlah-left">

            {{-- Tabel ringkasan --}}
            <div class="dw-chart-card">
                <h3 class="dw-chart-title">Ringkasan Keseluruhan</h3>
                <table class="dw-table">
                    <thead>
                        <tr>
                            <th style="text-align:left">Tingkat Pendidikan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listPendidikan as $p)
                        <tr>
                            <td style="text-align:left">{{ $p }}</td>
                            <td class="dw-td-total">{{ number_format($pendidikan[$p] ?? 0) }} orang</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Accordion per RW --}}
            <div class="dw-accordion-wrap">
                @for($i = 1; $i <= 23; $i++)
                @php
                    $nomorRw = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $rtData  = $perRw[$nomorRw] ?? [];
                    $rwTotal = 0;
                    foreach($rtData as $rt => $pData) {
                        foreach($listPendidikan as $p) $rwTotal += ($pData[$p] ?? 0);
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
                        <table class="dw-table">
                            <thead>
                                <tr><th>No</th><th>RT</th><th>Pendidikan</th><th>Jumlah</th></tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($rtData as $rt => $pendidikanData)
                                    @foreach($listPendidikan as $p)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>RT {{ $rt }}</td>
                                        <td style="text-align:left">{{ $p }}</td>
                                        <td class="dw-td-total">{{ $pendidikanData[$p] ?? 0 }} orang</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
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
                <h3 class="dw-chart-title">Sebaran Tingkat Pendidikan</h3>
                <div class="dw-chart-wrap" style="height:300px">
                    <canvas id="chartPendidikan"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const labels = @json($listPendidikan);
const values = @json(array_values(array_map(fn($p) => $pendidikan[$p] ?? 0, $listPendidikan)));
const colors = ['#2486d9','#1fa050','#e84393','#7c3aed','#0891b2','#f0a500','#e03030','#059669'];

new Chart(document.getElementById('chartPendidikan'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Jumlah',
            data: values,
            backgroundColor: colors.slice(0, labels.length),
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.x.toLocaleString('id-ID')} orang` } }
        },
        scales: {
            x: { grid: { color: 'rgba(0,0,0,.06)' }, beginAtZero: true, ticks: { font: { size: 11 } } },
            y: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>
@endsection