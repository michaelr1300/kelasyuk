@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($kelas) > 0)
                <div class="d-flex card-header mb-4">
                    <h2 class="col-9 pl-0 my-auto">Daftar Kelas</h2> 
                    @if(auth()->user()->role === 2)
                        <a class="col-3 btn btn-success" href="{{ route('kelas.create') }}">Buat Kelas</a>
                    @endif               
                </div>
                <table class="table table-striped">
                    <thead>
                        <th>Nama Kelas</th>
                        <th>Deskripsi</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $kelas)
                            <tr>
                                <td class="align-middle font-weight-bold">{{ $kelas->nama }}</td>
                                <td class="align-middle">{{ $kelas->deskripsi }}</td>
                                <td class="align-middle text-center">
                                    @if ($notAvailable->contains($kelas->id))
                                        <button class="btn btn-success disabled" disabled>Join</button>
                                    @else
                                        <form method="POST" action="{{ route('kelas.apply', ['id' => $kelas->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Join</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>               
            @else
                <h1 class="text-center">Belum ada kelas</h1>
            @endif
        </div>
    </div>
</div>
@endsection
