@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="card-header">{{ $kelas->nama }}</h2>
            <div class="card-body">
                <p>{{ $kelas->deskripsi }}</p>
            </div>

            @if(count($posts) > 0)
                @foreach ($posts as $post)
                    <h4 class="card-header">{{ $post->judul }}</h4>
                    <div class="card-body border">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>{{ $post->tanggal }}</td>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>{{ $post->waktu }}</td>
                                </tr>
                                <tr>
                                    <td>Platform</td>
                                    <td>{{ $post->platform }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a class="btn btn-info" href="{{ $post->link }}">Join</a>
                    </div>
                @endforeach
            @else
                <h4 class="text-center">Belum ada jadwal kelas</h3>
            @endif
            <a class="btn btn-info" href="{{ route('post.create', ['id' => $kelas->id]) }}">Create Post</a>
        </div>
    </div>
</div>
@endsection

