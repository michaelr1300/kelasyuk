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
                        <th scope="col" style="width: 35%">Nama Kelas</th>
                        <th scope="col" style="width: 40%">Deskripsi</th>
                        <th scope="col" style="width: 25%"></th>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $kelas)
                            <tr>
                                <td class="align-middle font-weight-bold">{{ $kelas->nama }}</td>
                                <td class="align-middle">{{ $kelas->deskripsi }}</td>
                                <td class="align-middle text-center">
                                    @if ($mendaftar->contains($kelas->id))
                                        <span class="text-dark">Menunggu Persetujuan</span>
                                    @elseif ($mengikuti->contains($kelas->id))
                                        <span class="text-success">Sudah Bergabung</span>
                                    @elseif ($kelas->user_id ===  auth()->user()->id)
                                        <span class="text-success">Admin</span>
                                    @else
                                        <form method="POST" action="{{ route('kelas.apply', ['id' => $kelas->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Bergabung</button>
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
