<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($kelas_id)
    {
        if (auth()->user()->role === 1) //Murid
        {
            return redirect()->action([KelasController::class, 'show'],['id' => $kelas_id])->with('error', 'Anda tidak memiliki akses!');
        }

        if (auth()->user()->role === 2) //Guru
        {
            return view('post.create')->with('kelas_id', $kelas_id);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
