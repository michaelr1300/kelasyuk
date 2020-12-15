@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-8 justify-content-center mx-auto">
        <div class="d-flex card-header">
            <h2 class="col-8 my-auto pl-0">{{ $kelas->nama }}</h2>

            @if(auth()->user()->id === $kelas->user_id)
                <div class="col-4 d-flex justify-content-end pr-0">
                    <form class="mr-2" method="GET" action="{{ route('kelas.edit', ['id' => $kelas->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-info text-white">
                            {{ __('Edit Kelas') }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('kelas.destroy', ['id' => $kelas->id]) }}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE"/>
                        <button type="submit" class="btn btn-danger text-white">
                            {{ __('Hapus Kelas') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="card-body">
            <p>{{ $kelas->deskripsi }}</p>
            @if(auth()->user()->id === $kelas->user_id)
                <div class="row justify-content-between">
                    <div class="col">
                        <a class="btn btn-success text-white" href="{{ route('post.create', ['id' => $kelas->id]) }}">Buat Post</a>
                    </div>
                </div>    
            @endif
        </div>
        
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <button id="defaultOpen" class="nav-link tablinks active" onclick="tab('kelas')">Kelas</button>
            </li>
            <li class="nav-item">
              <button class="nav-link tablinks" onclick="tab('member')">Anggota</button>
            </li>
        </ul>

        <div id="kelas" class="tabcontent">
            @if(count($posts) > 0)
                @foreach ($posts as $post)
                <div class="pt-4">
                    <div class="d-flex card-header">
                        <h4 class="col-8 pl-0 my-auto">{{ $post->judul }}</h4>
                        @if(auth()->user()->id === $kelas->user_id)
                            <div class="col-4 d-flex justify-content-end pr-0">
                                <a class="btn btn-info text-white mr-2" href="{{ route('post.edit', ['id' => $post->id]) }}">Edit</a>
                                <form method="POST" action="{{ route('post.destroy', ['id' => $post->id]) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE"/>
                                    <button type="submit" class="btn btn-danger text-white">
                                        {{ __('Hapus') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="col border">
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
                                <tr>
                                    <td> </td>
                                    <td>
                                        @if ( str_contains($post->link, 'http://' ?? 'https://') )
                                            <a class="btn btn-info text-white px-4" href="{{ $post->link }} " target="_blank">Masuk</a>
                                        @else
                                            <a class="btn btn-info text-white px-4" href="http://{{ $post->link }}" target="_blank">Masuk</a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                    
                @endforeach
            @else
                <h4 class="text-center my-4">Belum ada jadwal kelas</h4>
            @endif
        </div>

        <div id="member" class="tabcontent">
            <div class="col justify-content-center">
                @if (auth()->user()->id === $kelas->user_id)
                    @if (count($pendings)>0)
                        <div class="pt-2 pb-5">
                            <h4 class="text-center py-2">Menunggu Persetujuan</h4> 
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
                                <div class="text-center">
                                    <button type="submit" name="action" value="accept" class="btn btn-success">Terima</button>
                                    <button type="submit" name="action" value="deny" class="btn btn-danger">Tolak</button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif
                
                <div class="py-2">
                    <h4 class="text-center py-2">Anggota Kelas</h4>
                    <table class="table table-striped">
                        <thead>
                            <th>Nama</th>
                            <th>Email</th>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td class="align-middle">{{ $member->user->name }}</td>
                                    <td class="align-middle">{{ $member->user->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    //Default tab on load
    document.getElementById("defaultOpen").click();

    function tab(tabName) {
        // Declare all variables
        var i, tabcontent, tablinks;
    
        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) 
        {
            tabcontent[i].style.display = "none";
        }
    
        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) 
        {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
    
        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        event.currentTarget.className += " active";
    }
</script>
@endsection

