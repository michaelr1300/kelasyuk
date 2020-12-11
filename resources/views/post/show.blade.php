@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Testing</h2>
            <div>Judul: {{ $post->judul }}</div>
            <div>Link: {{ $post->link }}</div>
            <div>Platform: {{ $post->platform }}</div>
            <div>Tanggal: {{ $post->tanggal }}</div>
            <div>Waktu: {{ $post->waktu }}</div>
            <div>Kelas: {{ $post->kelas_id }}</div>
        </div>
    </div>
</div>
@endsection

