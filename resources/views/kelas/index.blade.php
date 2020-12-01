@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($kelas) > 0)
                <h2 class="card-header">Daftar Kelas</h2>
                @foreach ($kelas as $kelas)
                    <div class="card-body">
                        <a href=""><b>{{ $kelas->nama }}</b></a>
                        <br>
                        <p>{{ $kelas->deskripsi }}</p>
                    </div>
                @endforeach
            @else
                <h1 class="text-center">Anda belum mengikuti kelas apapun</h1>
            @endif
        </div>
    </div>
</div>
@endsection
