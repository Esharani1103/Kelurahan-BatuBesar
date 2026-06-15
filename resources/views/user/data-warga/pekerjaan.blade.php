@extends('layouts.user')
@section('title', 'Data Pekerjaan')

@push('styles')
    @vite('resources/css/datawarga.css')
@endpush

@section('content')
<div class="dw-wrap">

    <div class="dw-header">
        <div class="dw-title-row">
            <div class="dw-title-bar"></div>
            <h1 class="dw-title">Data Pekerjaan Kelurahan Batu Besar</h1>
        </div>
        <p class="dw-subtitle">Sebaran jenis pekerjaan penduduk per RW/RT.</p>
    </div>

    <div class="dw-jumlah-layout">

        {{-- KIRI --}}
        <div class="dw-jumlah-left">

            {{-- Tabel ringkasan --}}
            <div class="dw-chart-card">
                <h3 class="dw-chart-title">Ringkasan Keseluruhan</h3>
                <table class="dw-table">
                    <thead>
                        <tr>
                            <th style="text-align:left">Jenis Pekerjaan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listPekerjaan as $p)
                        <tr>
                            <td style="text-align:left">{{ $p }}</td>
                            <td class="dw-td-total">{{ number_format($pekerjaan[$p] ?? 0) }} orang</td>
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
                        foreach($listPekerjaan as $p) $rwTotal += ($pData[$p] ?? 0);
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

                        <div class="grid gap-4">
                            @foreach($rtData as $rt => $pekerjaanData)

                            @php
                            $totalRt = 0;

                            foreach($listPekerjaan as $p) {
                            $totalRt += ($pekerjaanData[$p] ?? 0);
                            }
                            @endphp

                        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">

                        <div class="flex justify-between items-center px-4 py-3 bg-gray-100 border-b">

                        <div class="font-bold text-green-700">
                        RT {{ $rt }}
                        </div>

                        <div class="font-bold text-gray-700">
                        {{ $totalRt }} Jiwa
                        </div>

                    </div>

        <div class="p-4">

            <table class="w-full text-sm">

                <tbody>

                    @foreach($listPekerjaan as $p)

                    @if(($pekerjaanData[$p] ?? 0) > 0)

                    <tr class="border-b">

                        <td class="py-2 text-left">
                            {{ $p }}
                        </td>

                        <td class="py-2 text-right font-semibold">
                            {{ $pekerjaanData[$p] }} orang
                        </td>

                    </tr>

                    @endif

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@endforeach

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
                <h3 class="dw-chart-title">Sebaran Jenis Pekerjaan</h3>
                <div class="dw-chart-wrap" style="height:320px">
                    <canvas id="chartPekerjaan"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const pekerjaanLabels = @json($listPekerjaan);
const pekerjaanValues = @json(array_values(array_map(fn($p) => $pekerjaan[$p] ?? 0, $listPekerjaan)));
const pekerjaanColors = [
    '#2486d9','#1fa050','#f0a500','#7c3aed',
    '#e84393','#0891b2','#e03030','#059669',
    '#d97706','#6366f1','#ec4899','#14b8a6'
];

new Chart(document.getElementById('chartPekerjaan'), {
    type: 'bar',
    data: {
        labels: pekerjaanLabels,
        datasets: [{
            label: 'Jumlah',
            data: pekerjaanValues,
            backgroundColor: pekerjaanColors.slice(0, pekerjaanLabels.length),
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