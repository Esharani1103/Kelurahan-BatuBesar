@extends('layouts.user')

@section('content')

<div class="container py-5">

    <h2 class="text-2xl font-bold mb-4">
        Data Pekerjaan Keseluruhan
    </h2>

    <table class="table-auto border-collapse border border-gray-300 w-full text-center mb-10 bg-gray-100">

        <thead class="bg-gray-200">
            <tr>
                <th class="border px-12 py-8">Pekerjaan</th>
                <th class="border px-12 py-8">Jumlah</th>
            </tr>
        </thead>

        <tbody>

            @foreach($listPekerjaan as $p)

            <tr class="bg-gray-100">

                <td class="border px-12 py-8">
                    {{ $p }}
                </td>

                <td class="border px-12 py-8">
                    {{ $pekerjaan[$p] ?? 0 }} orang
                </td>

            </tr>

            @endforeach

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

        <summary class="cursor-pointer px-6 py-4 text-2xl font-bold">
            RW {{ $nomorRw }}
        </summary>

        <div class="p-4">

            @if(count($rtData) > 0)

            <table class="table-auto border-collapse border border-gray-300 w-full text-center bg-gray-100">

                <thead class="bg-gray-200">

                    <tr>
                        <th class="border px-6 py-4">No</th>
                        <th class="border px-6 py-4">RT</th>
                        <th class="border px-6 py-4">Pekerjaan</th>
                        <th class="border px-6 py-4">Jumlah</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($rtData as $rt => $pekerjaanData)

                        @foreach($listPekerjaan as $p)

                        <tr class="bg-gray-100">

                            <td class="border px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-4 py-3">
                                RT {{ $rt }}
                            </td>

                            <td class="border px-4 py-3">
                                {{ $p }}
                            </td>

                            <td class="border px-4 py-3">
                                {{ $pekerjaanData[$p] ?? 0 }} orang
                            </td>

                        </tr>

                        @endforeach

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
