@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($kelas) > 0)
                <div class="d-flex mb-4">
                    <h2>Daftar Kelas</h2>                  
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
                                <td class="align-middle text-center"><a class="btn btn-success">Join</a></td>
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
