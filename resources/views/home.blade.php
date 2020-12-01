@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

                <p class="card-header">Daftar Kelas</h2>
                <div class="card-body">
                    <a href=""><b>Big Data dan Analitik</b></a>
                    <br>
                    <p>Setiap hari Selasa pukul 13:00</p>
                    <br><br>
                    <a href=""><b>Pengalaman Pengguna</b></a>
                    <br>
                    <p>Setiap hari Rabu pukul 07:15</p>
                    <br><br>
                    <a href=""><b>Pemrograman Berbasis Web</b></a>
                    <br>
                    <p>Setiap hari Rabu pukul 10:00</p>
                </div>
        </div>
    </div>
</div>
@endsection
