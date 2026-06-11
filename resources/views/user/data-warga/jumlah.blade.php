@extends('layouts.user')
@section('title', 'Jumlah Penduduk')

@push('styles')
    @vite('resources/css/datawarga.css')
@endpush

@section('content')
<div class="dw-wrap">

    {{-- Header --}}
    <div class="dw-header">
        <div class="dw-title-row">
            <div class="dw-title-bar"></div>
            <h1 class="dw-title">Jumlah Penduduk Kelurahan Batu Besar</h1>
        </div>
        <p class="dw-subtitle">Data keseluruhan jumlah penduduk berdasarkan jenis kelamin per RW/RT.</p>
    </div>

    {{-- Layout: Tabel kiri + Diagram kanan --}}
    <div class="dw-jumlah-layout">

        {{-- KOLOM KIRI: Ringkasan + Accordion RW --}}
        <div class="dw-jumlah-left">

            {{-- Kartu ringkasan total --}}
            <div class="dw-summary-cards">
                <div class="dw-summary-item dw-summary-blue">
                    <div class="dw-summary-icon">👨</div>
                    <div class="dw-summary-val">{{ number_format($laki) }}</div>
                    <div class="dw-summary-label">Laki-Laki</div>
                </div>
                <div class="dw-summary-item dw-summary-pink">
                    <div class="dw-summary-icon">👩</div>
                    <div class="dw-summary-val">{{ number_format($perempuan) }}</div>
                    <div class="dw-summary-label">Perempuan</div>
                </div>
                <div class="dw-summary-item dw-summary-green">
                    <div class="dw-summary-icon">👥</div>
                    <div class="dw-summary-val">{{ number_format($total) }}</div>
                    <div class="dw-summary-label">Total Penduduk</div>
                </div>
            </div>

            {{-- Accordion per RW --}}
            <div class="dw-accordion-wrap">
                @for($i = 1; $i <= 23; $i++)
                @php
                    $nomorRw = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $rtData  = $perRw[$nomorRw] ?? [];
                    $rwTotal = collect($rtData)->sum('total');
                @endphp
                <details class="dw-accordion" id="rw-{{ $nomorRw }}">
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
                                <tr>
                                    <th>No</th>
                                    <th>RT</th>
                                    <th>Laki-Laki</th>
                                    <th>Perempuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rtData as $rt => $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>RT {{ $rt }}</td>
                                    <td>{{ $data['laki'] }}</td>
                                    <td>{{ $data['perempuan'] }}</td>
                                    <td class="dw-td-total">{{ $data['total'] }}</td>
                                </tr>
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

        {{-- KOLOM KANAN: Diagram --}}
        <div class="dw-jumlah-right">

            {{-- Diagram Donut: L vs P --}}
            <div class="dw-chart-card">
                <h3 class="dw-chart-title">Perbandingan Jenis Kelamin</h3>
                <div class="dw-chart-wrap">
                    <canvas id="chartDonut"></canvas>
                </div>
                <div class="dw-chart-legend">
                    <span class="dw-legend-dot" style="background:#2486d9"></span> Laki-Laki ({{ $laki }})
                    <span class="dw-legend-dot" style="background:#e84393;margin-left:16px"></span> Perempuan ({{ $perempuan }})
                </div>
            </div>

            {{-- Diagram Bar: Per RW --}}
            <div class="dw-chart-card" style="margin-top:16px">
                <h3 class="dw-chart-title">Jumlah Penduduk per RW</h3>
                <div class="dw-chart-wrap" style="height:280px">
                    <canvas id="chartBar"></canvas>
                </div>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Data dari Laravel ──────────────────────────────────────────
const laki      = {{ $laki }};
const perempuan = {{ $perempuan }};

const perRwData = @json($perRw);
const rwLabels  = [];
const rwTotals  = [];

for (let i = 1; i <= 23; i++) {
    const key  = String(i).padStart(2, '0');
    const data = perRwData[key] || {};
    const tot  = Object.values(data).reduce((s, d) => s + (d.total || 0), 0);
    if (tot > 0) {
        rwLabels.push('RW ' + key);
        rwTotals.push(tot);
    }
}

// ── Donut Chart ────────────────────────────────────────────────
new Chart(document.getElementById('chartDonut'), {
    type: 'doughnut',
    data: {
        labels: ['Laki-Laki', 'Perempuan'],
        datasets: [{
            data: [laki, perempuan],
            backgroundColor: ['#2486d9', '#e84393'],
            borderWidth: 0,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
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

// ── Bar Chart ──────────────────────────────────────────────────
new Chart(document.getElementById('chartBar'), {
    type: 'bar',
    data: {
        labels: rwLabels,
        datasets: [{
            label: 'Jumlah Penduduk',
            data: rwTotals,
            backgroundColor: 'rgba(11,92,46,.75)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.parsed.y.toLocaleString('id-ID')} jiwa`
                }
            }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 } } },
            y: { grid: { color: 'rgba(0,0,0,.06)' }, beginAtZero: true,
                 ticks: { font: { size: 11 } } }
        }
    }
});
</script>
@endsection