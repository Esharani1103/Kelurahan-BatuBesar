@extends('layouts.user')
@section('title', 'Data Agama')

@push('styles')
    @vite('resources/css/datawarga.css')
@endpush

@section('content')
<div class="dw-wrap">

    <div class="dw-header">
        <div class="dw-title-row">
            <div class="dw-title-bar"></div>
            <h1 class="dw-title">Data Agama Kelurahan Batu Besar</h1>
        </div>
        <p class="dw-subtitle">Sebaran agama penduduk per RW/RT.</p>
    </div>

    <div class="dw-jumlah-layout">

        {{-- KIRI: Tabel + Accordion --}}
        <div class="dw-jumlah-left">

            {{-- Tabel ringkasan --}}
            <div class="dw-chart-card">
                <h3 class="dw-chart-title">Ringkasan Keseluruhan</h3>
                <table class="dw-table">
                    <thead>
                        <tr>
                            <th style="text-align:left">Agama</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listAgama as $a)
                        <tr>
                            <td style="text-align:left">{{ $a }}</td>
                            <td class="dw-td-total">{{ number_format($agama[$a] ?? 0) }} orang</td>
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
                    foreach($rtData as $rt => $aData) {
                        foreach($listAgama as $a) $rwTotal += ($aData[$a] ?? 0);
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
                                <tr><th>No</th><th>RT</th><th>Agama</th><th>Jumlah</th></tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($rtData as $rt => $agamaData)
                                    @foreach($listAgama as $a)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>RT {{ $rt }}</td>
                                        <td style="text-align:left">{{ $a }}</td>
                                        <td class="dw-td-total">{{ $agamaData[$a] ?? 0 }} orang</td>
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
                <h3 class="dw-chart-title">Sebaran Agama Penduduk</h3>
                <div class="dw-chart-wrap">
                    <canvas id="chartAgama"></canvas>
                </div>
                <div class="dw-chart-legend" style="flex-wrap:wrap;gap:8px;justify-content:flex-start;margin-top:12px">
                    @php
                        $agamaColors = ['#1fa050','#2486d9','#f0a500','#e84393','#7c3aed','#0891b2','#e03030','#059669'];
                    @endphp
                    @foreach($listAgama as $idx => $a)
                    <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;color:#6a8a72">
                        <span class="dw-legend-dot" style="background:{{ $agamaColors[$idx % count($agamaColors)] }}"></span>
                        {{ $a }} ({{ number_format($agama[$a] ?? 0) }})
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const agamaLabels = @json($listAgama);
const agamaValues = @json(array_values(array_map(fn($a) => $agama[$a] ?? 0, $listAgama)));
const agamaColors = ['#1fa050','#2486d9','#f0a500','#e84393','#7c3aed','#0891b2','#e03030','#059669'];

new Chart(document.getElementById('chartAgama'), {
    type: 'doughnut',
    data: {
        labels: agamaLabels,
        datasets: [{
            data: agamaValues,
            backgroundColor: agamaColors.slice(0, agamaLabels.length),
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
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed.toLocaleString('id-ID')} orang`
                }
            }
        }
    }
});
</script>
@endsection