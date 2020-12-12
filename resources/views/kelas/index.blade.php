@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($kelas) > 0)
            <div class="card">
                <div class="d-flex card-header">
                    <h2 class="col-9 pl-0 my-auto">Daftar Kelas</h2>
                    @if (auth()->user()->role === 1)
                        <a class="col-3 btn btn-success" href="{{ route('kelas.browse') }}">Tambah Kelas</a>
                    @elseif(auth()->user()->role === 2)
                        <a class="col-3 btn btn-success" href="{{ route('kelas.create') }}">Tambah Kelas</a>
                    @endif                    
                </div>
                @foreach ($kelas as $kelas)
                    <div class="card-body">
                        <a href="{{ route('kelas.show', [$kelas->id]) }}"><b>{{ $kelas->nama }}</b></a>
                        <br>
                        <p>{{ $kelas->deskripsi }}</p>
                    </div>
                @endforeach
            </div>
            @else
            <div class="d-flex flex-column">
                <h1 class="text-center">Anda belum mengikuti kelas apapun</h1>
                <div class="mx-auto pt-4">
                    <a class="btn btn-success" href="{{ route('kelas.browse') }}">Cari Kelas Sekarang</a>
                </div>
            </div>
                
            @endif
        </div>
    </div>
</div>
@endsection
