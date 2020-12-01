@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($kelas) > 0)
                @foreach (kelas as $kelas)
                <div class="card">
                    <div class="card-header">{{ $kelas->deskripsi }}</div>

                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ $kelas->deskripsi }}
                        </div>
                    </div>
                </div>    
                @endforeach
            @else
                <h1 class="text-center">Anda belum mengikuti kelas apapun</h1>
            @endif
        </div>
    </div>
</div>
@endsection

