@extends('layouts.user')

@section('content')

<div class="container py-5">

<h3 class="fw-bold text-success mb-4">
Jumlah Kependudukan Kelurahan Batu Besar
</h3>

<div class="row text-center">

<div class="col-md-4 mb-3">
<div class="card shadow">
<div class="card-body">
<h5>Total Penduduk</h5>
<h2 class="fw-bold">{{ $total }}</h2>
</div>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="card shadow">
<div class="card-body">
<h5>Laki-Laki</h5>
<h2 class="fw-bold">{{ $laki }}</h2>
</div>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="card shadow">
<div class="card-body">
<h5>Perempuan</h5>
<h2 class="fw-bold">{{ $perempuan }}</h2>
</div>
</div>
</div>

</div>

</div>

@endsection