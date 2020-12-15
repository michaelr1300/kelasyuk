@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center">Menunggu Persetujuan</h2>             
            <form method="POST" action="{{ route('kelas.response', ['id' => $kelas->id]) }}">
                @csrf
                <table class="table table-striped">
                    <thead>
                        <th></th>
                        <th>Nama</th>
                        <th>Email</th>
                    </thead>
                    <tbody>
                        @foreach ($pendings as $pending)
                            <tr>
                                <td class="align-middle text-center">
                                    <input type="checkbox" name="apply_ids[]" value="{{ $pending->id }}">
                                </td>
                                <td class="align-middle">{{ $pending->user->name }}</td>
                                <td class="align-middle">{{ $pending->user->email }}</td>
                            </tr>
                        @endforeach
                            
                    </tbody>
                </table>
                <button type="submit" name="action" value="accept" class="btn btn-success">Terima</button>
                <button type="submit" name="action" value="deny" class="btn btn-danger">Tolak</button>
            </form>
        </div>

        <div class="col-md-8">
            <h2 class="text-center">Anggota Kelas</h2>             
            <form method="POST" action="{{ route('kelas.response', ['id' => $kelas->id]) }}">
                @csrf
                <table class="table table-striped">
                    <thead>
                        <th></th>
                        <th>Nama</th>
                        <th>Email</th>
                    </thead>
                    <tbody>
                        @foreach ($pendings as $pending)
                            <tr>
                                <td class="align-middle text-center">
                                    <input type="checkbox" name="apply_ids[]" value="{{ $pending->id }}">
                                </td>
                                <td class="align-middle">{{ $pending->user->name }}</td>
                                <td class="align-middle">{{ $pending->user->email }}</td>
                            </tr>
                        @endforeach
                            
                    </tbody>
                </table>
                <button type="submit" name="action" value="accept" class="btn btn-success">Terima</button>
                <button type="submit" name="action" value="deny" class="btn btn-danger">Tolak</button>
            </form>
        </div>

    </div>
</div>
@endsection
