<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mengikuti;
use App\Models\Mengajar;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Post;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = auth()->user()->id;
        if (auth()->user()->role === 1) //Murid
        {
            $mengikutis = Mengikuti::where('user_id', $id)->get();
            $kelas = collect([]);
            foreach ($mengikutis as $mengikuti)
            {
                $kelas->push(Kelas::find($mengikuti->kelas_id));
            }
        }

        if (auth()->user()->role === 2) //Guru
        {
            $kelas= Kelas::where('user_id', $id)->get();
        }
        return view('kelas.index')->with('kelas',$kelas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role === 1) //Murid
        {
            return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda tidak memiliki akses!');
        }

        if (auth()->user()->role === 2) //Guru
        {
            return view('kelas.create');
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
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $kelas = new Kelas;
        $kelas->nama = $request->input('nama');
        $kelas->deskripsi = $request->input('deskripsi');
        $kelas->user_id = auth()->user()->id;
        $kelas->save();

        return redirect()->action([KelasController::class, 'index'])->with('success','Kelas berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = auth()->user()->id;
        $kelas = Kelas::find($id);

        if (auth()->user()->role === 1) //Murid
        {
            $joinedClass = Mengikuti::where('user_id', $user_id)->pluck('kelas_id'); //Kelas yang diikuti
            if($joinedClass->contains($id)) //Jika murid mengikuti kelas
            {
                $post = Post::where('kelas_id', $id)->get();
                return view('kelas.show', 
                [
                    'kelas' => $kelas,
                    'post' => $post,
                ] );
            }
            else //Murid tidak mengikuti kelas
            {
                return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda tidak mengikuti kelas ini!');
            }
        }   
        
        if (auth()->user()->role === 2) //Guru
        {
            if($kelas->user_id === $user_id) //Kelas dibuat oleh guru
            {
                $post = Post::where('kelas_id', $id)->get();
                return view('kelas.show', 
                [
                    'kelas' => $kelas,
                    'post' => $post,
                ] );
            }
            else
            {
                return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda tidak memiliki akses untuk kelas ini!');
            }
        }
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
        $kelas = Kelas::find($id);

        if (auth()->user()->role === 2) //Guru
        {
            if($kelas->user_id === $user_id) //Kelas dibuat oleh guru
            {
                return view('kelas.edit')->with('kelas', $kelas);
            }
            else
            {
                return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda tidak memiliki akses untuk kelas ini!');
            }
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
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $kelas = Kelas::find($id);
        $kelas->nama = $request->input('nama');
        $kelas->deskripsi = $request->input('deskripsi');
        $kelas->save();

        return redirect()->action([KelasController::class, 'index'])->with('success','Kelas berhasil dibuat!');
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
        $kelas = Kelas::find($id);

        if (auth()->user()->role === 1) //Murid
        {
            return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda tidak memiliki akses!');
        }

        if (auth()->user()->role === 2) //Guru
        {
            if($kelas->user_id === $user_id) //Kelas dibuat oleh guru
            {
                $kelas->delete();

                return redirect()->action([KelasController::class, 'index'])->with('success', 'Kelas telah dihapus!');
            }
            else
            {
                return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda tidak memiliki akses untuk kelas ini!');
            }
        }
        
    }
}
