@extends('admin.layouts.app')

@section('title')
Kelola Layanan
@endsection

@section('content')

<div class="container py-8">

    <h1 class="text-3xl font-bold mb-6">
        Data Layanan
    </h1>

    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">

            {{ session('success') }}

        </div>

    @endif

    <table class="w-full border border-gray-300 text-center">

        <thead class="bg-gray-100">

            <tr>

                <th class="border px-4 py-3">No</th>
                <th class="border px-4 py-3">Nama</th>
                <th class="border px-4 py-3">Kategori</th>
                <th class="border px-4 py-3">Pesan</th>
                <th class="border px-4 py-3">Foto</th>
                <th class="border px-4 py-3">Waktu Kirim</th>

            </tr>

        </thead>

        <tbody>

            @forelse($layanan as $item)

            <tr>

                <td class="border px-4 py-3">
                    {{ $loop->iteration }}
                </td>

                <td class="border px-4 py-3">

                    {{ $item->anonim ? 'Anonim' : $item->nama }}

                </td>

                <td class="border px-4 py-3">
                    {{ $item->kategori }}
                </td>

                <td class="border px-4 py-3">
                    {{ $item->pesan }}
                </td>

                <td class="border px-4 py-3">

                    @if($item->foto)

                        <img src="{{ asset('storage/'.$item->foto) }}"
                             class="w-24 mx-auto rounded">

                    @else

                        -

                    @endif

                </td>

                <td class="border px-4 py-3">

                     {{ $item->created_at->format('d M Y H:i') }}

                </td>
            </tr>

            @empty

            <tr>

                <td colspan="7"
                    class="border px-4 py-3 text-gray-500">

                    Belum ada data

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    <div class="mt-4">

        {{ $layanan->links() }}

    </div>

</div>

@endsection