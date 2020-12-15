@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('post.update', ["id" => $post->id]) }}">
                @csrf

                <div class="form-group row">
                    <label for="judul" class="col-md-4 col-form-label text-md-right">{{ __('Judul') }}</label>

                    <div class="col-md-6">
                        <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ $post->judul }}" required autocomplete="judul" autofocus>

                        @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="link" class="col-md-4 col-form-label text-md-right">{{ __('Link') }}</label>
                
                    <div class="col-md-6">
                        <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ $post->link }}" required autocomplete="link" autofocus>
                
                        @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="platform" class="col-md-4 col-form-label text-md-right">{{ __('Platform') }}</label>
                
                    <div class="col-md-6">
                        <input id="platform" type="text" class="form-control @error('platform') is-invalid @enderror" name="platform" value="{{ $post->platform }}" required autocomplete="platform" autofocus>
                
                        @error('platform')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal') }}</label>
                
                    <div class="col-md-6">
                        <input id="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $post->tanggal }}" required autocomplete="tanggal" autofocus>
                
                        @error('tanggal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="waktu" class="col-md-4 col-form-label text-md-right">{{ __('Waktu') }}</label>
                
                    <div class="col-md-6">
                        <input id="waktu" type="time" class="form-control @error('waktu') is-invalid @enderror" name="waktu" value="{{ $post->waktu }}" required autocomplete="waktu" autofocus>
                
                        @error('waktu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <input type="hidden" name="_method" value="PUT"/>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Simpan') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
