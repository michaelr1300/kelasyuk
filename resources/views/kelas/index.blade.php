@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($kelas) > 0)
            <div class="card">
                <div class="d-flex card-header">
                    <h2 class="col-9 pl-0 my-auto">Kelas Saya</h2>
                    @if (auth()->user()->role === 1)
                        <a class="col-3 btn btn-success" href="{{ route('kelas.browse') }}">Tambah Kelas</a>
                    @elseif(auth()->user()->role === 2)
                        <a class="col-3 btn btn-success" href="{{ route('kelas.create') }}">Buat Kelas</a>
                    @endif                    
                </div>
                @foreach ($kelas as $kelas)
                    <div class="card-body">
                        <h4><a href="{{ route('kelas.show', [$kelas->id]) }}"><b>{{ $kelas->nama }}</b></a></h4>
                        @if ($kelas->user_id === auth()->user()->id)
                            <span class="font-weight-bold text-success mb-4">Admin</span>
                        @endif
                        <p class="mb-0">{{ $kelas->deskripsi }}</p>
                        
                    </div>
                @endforeach
            </div>
            @else
            <div class="d-flex flex-column">
                <h1 class="text-center">Anda belum mengikuti kelas apapun</h1>
                <div class="mx-auto pt-4">
                    @if(auth()->user()->role === 2)
                        <a class="btn btn-success" href="{{ route('kelas.create') }}">Buat Kelas</a>
                    @else
                        <a class="btn btn-success" href="{{ route('kelas.browse') }}">Cari Kelas Sekarang</a>
                    @endif     
                </div>
            </div>
                
            @endif
        </div>
    </div>
</div>
@endsection
