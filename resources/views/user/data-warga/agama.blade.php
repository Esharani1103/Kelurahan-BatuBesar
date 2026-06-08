@extends('layouts.user')

@section('content')

<div class="container py-5">

    <h2 class="text-2xl font-bold mb-4">
        Data Agama Keseluruhan
    </h2>

    <table class="w-full border border-gray-300 mb-5 text_center">

        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Agama</th>
                <th class="border px-4 py-2">Jumlah</th>
            </tr>
        </thead>

        <tbody>

            @foreach($listAgama as $a)

           <tr>
           <td class="border px-4 py-2">
           {{ $a }}
           </td>

           <td class="border px-4 py-2">
          {{ $agama[$a] }} orang
          </td>
          </tr>

           @endforeach

        </tbody>

    </table>

    <br><br>

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
                        <th class="border px-4 py-3">Agama</th>
                        <th class="border px-4 py-3">Jumlah</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($rtData as $rt => $agamaData)

                        @foreach($listAgama as $a)

                        <tr>

                        <td class="border px-4 py-3">
                        {{ $loop->iteration }}
                        </td>

                        <td class="border px-4 py-3">
                        RT {{ $rt }}
                        </td>

                        <td class="border px-4 py-3">
                        {{ $a }}
                        </td>

                        <td class="border px-4 py-3">
                        {{ $agamaData[$a] ?? 0 }} orang
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
