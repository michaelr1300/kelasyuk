<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($kelas_id)
    {
        $kelas = Kelas::find($kelas_id);
        $user_id = auth()->user()->id;

        //User admin kelas
        if($kelas->user_id === $user_id) 
        {
            return view('post.create')->with('kelas_id', $kelas_id);
        }
        
        else
        {
            return redirect()->action([KelasController::class, 'show'],['id' => $kelas_id])->with('error', 'Anda tidak memiliki akses!');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'judul' => 'required',
            'link' => 'required',
            'platform' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
        ]);

        $post = new Post;
        $post->judul = $request->input('judul');
        $post->link = $request->input('link');
        $post->platform = $request->input('platform');
        $post->tanggal = $request->input('tanggal');
        $post->waktu = $request->input('waktu');
        $post->kelas_id = $request->input('kelas_id');
        $post->save();

        $kelas_id = $request->input('kelas_id');

        return redirect()->action([KelasController::class, 'show'],['id' => $kelas_id])->with('success', 'Post berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = auth()->user()->id;
        $post = Post::find($id); //Post yang akan diedit
        $kelas = Kelas::find($post->kelas_id); //Kelas tempat post
        
        //Kelas dibuat oleh user (user berhak edit post)
        if($kelas->user_id === $user_id) 
        {
            return view('post.edit')->with('post', $post);
        }

        //User bukan admin kelas jadi tidak berhak edit post
        else 
        {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'judul' => 'required',
            'link' => 'required',
            'platform' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
        ]);

        $post = Post::find($id);
        $post->judul = $request->input('judul');
        $post->link = $request->input('link');
        $post->platform = $request->input('platform');
        $post->tanggal = $request->input('tanggal');
        $post->waktu = $request->input('waktu');
        $post->save();

        return redirect()->action([KelasController::class, 'show'],['id' => $post->kelas_id])->with('success', 'Post berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = auth()->user()->id;
        $post = Post::find($id); //Post yang akan dihapus
        $kelas = Kelas::find($post->kelas_id); //Kelas tempat post
        
        //Kelas dibuat oleh user (user berhak hapus post)
        if($kelas->user_id === $user_id) 
        {
            $post->delete();
            return redirect()->action([KelasController::class, 'show'],['id' => $post->kelas_id])->with('success', 'Post berhasil dihapus!');
        }

        //User bukan admin kelas jadi tidak berhak hapus post
        else 
        {
            return back();
        }
    }
}
