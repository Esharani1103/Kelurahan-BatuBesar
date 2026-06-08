@extends('layouts.user')

@section('content')

<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4">Kelompok Umur Keseluruhan</h2>

<table class="w-full border border-gray-300 mb-5 text_center">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-4 py-2">0 - 5 th</th>
            <th class="border px-4 py-2">6 - 12 th</th>
            <th class="border px-4 py-2">13 - 17 th</th>
            <th class="border px-4 py-2">18 - 30 th</th>
            <th class="border px-4 py-2">31 - 50 th</th>
            <th class="border px-4 py-2">>50 th</th>
        </tr>
    </thead>

    <tbody>
        <tr class="text-center">
            @foreach($kelompokUmur as $jumlah)
                <td class="border p-2">
                    {{ $jumlah }} orang
                </td>
            @endforeach
        </tr>
    </tbody>
</table>


{{-- ========================= --}}
{{-- PER RW --}}
{{-- ========================= --}}

@for($i = 1; $i <= 23; $i++)

@php
    $nomorRw = str_pad($i, 2, '0', STR_PAD_LEFT);
    $rtData = $perRw[$nomorRw] ?? [];
@endphp

<details class="mb-4">
    
    <summary class="cursor-pointer px-4 py-3 text-2xl font-bold">
        RW {{ $nomorRw }}
    </summary>

    <div class="p-4">

        @if(count($rtData) > 0)

        <table class="table-auto border-collapse border border-gray-300 w-full text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-3">No</th>
                    <th class="border px-4 py-3">RT</th>
                    <th class="border px-4 py-3">0 - 5 th</th>
                    <th class="border px-4 py-3">6 - 12 th</th>
                    <th class="border px-4 py-3">13 - 17 th</th>
                    <th class="border px-4 py-3">18 - 30 th</th>
                    <th class="border px-4 py-3">31 - 50 th</th>
                    <th class="border px-4 py-3">>50 th</th>
                </tr>
            </thead>

            <tbody>
                @foreach($rtData as $rt => $umur)
                <tr>
                    <td class="border px-4 py-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="border px-4 py-3">
                        RT {{ $rt }}
                    </td>

                    <td class="border px-4 py-3">{{ $umur['0-5'] ?? 0 }} orang</td>
                    <td class="border px-4 py-3">{{ $umur['6-12'] ?? 0 }} orang</td>
                    <td class="border px-4 py-3">{{ $umur['13-17'] ?? 0 }} orang</td>
                    <td class="border px-4 py-3">{{ $umur['18-30'] ?? 0 }} orang</td>
                    <td class="border px-4 py-3">{{ $umur['31-50'] ?? 0 }} orang</td>
                    <td class="border px-4 py-3">{{ $umur['>50'] ?? 0 }} orang</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else

        <div class="text-gray-500 italic">
            Belum ada data
        </div>

        @endif

    </div>
</details>
</div>

@endfor
@endsection
