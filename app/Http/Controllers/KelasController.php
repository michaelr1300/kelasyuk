<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mendaftar;
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

        //Kelas yang dibuat user
        $kelas= Kelas::where('user_id', $id)->get();

        //Kelas yang diikuti user
        $mengikutis = Mengikuti::where('user_id', $id)->get();
        foreach ($mengikutis as $mengikuti)
        {
            $kelas->push(Kelas::find($mengikuti->kelas_id));
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

        elseif (auth()->user()->role === 2) //Guru
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

        //Kelas yang diikuti user
        $joinedClass = Mengikuti::where('user_id', $user_id)->pluck('kelas_id');

        //Jika user mengikuti kelas
        if($joinedClass->contains($id))
        {
            //Data post di kelas
            $posts = Post::where('kelas_id', $id)->get();

            //Data anggota kelas
            $members = Mengikuti::where('kelas_id', $id)->get();
            foreach ( $members as $member )
            {
                $member->user = User::find($member->user_id);
            }

            return view('kelas.show', 
            [
                'kelas' => $kelas,
                'posts' => $posts,
                'members' => $members
            ] );
        } 

        //Jika user pembuat kelas
        elseif($kelas->user_id === $user_id)
        {
            //Data post di kelas
            $posts = Post::where('kelas_id', $id)->get();

            //Data anggota kelas
            $members = Mengikuti::where('kelas_id', $id)->get();
            foreach ( $members as $member )
            {
                //User yang anggota kelas
                $member->user = User::find($member->user_id);
            }

            //Data pending request mendaftar kelas
            $pendings = Mendaftar::where('kelas_id', $id)->get();
            foreach ( $pendings as $pending )
            {
                //User yang request join kelas
                $pending->user = User::find($pending->user_id);
            }

            return view('kelas.show', 
            [
                'kelas' => $kelas,
                'posts' => $posts,
                'pendings' => $pendings,
                'members' => $members
            ] );
        }

        //User bukan anggota atau pembuat kelas
        else
        {
            return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda tidak memiliki akses untuk kelas ini!');
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

        return redirect()->action([KelasController::class, 'show'], ['id' => $kelas->id])->with('success','Kelas berhasil diubah!');
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

        elseif (auth()->user()->role === 2) //Guru
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

    public function browse()
    {
        $user_id = auth()->user()->id;
        $kelas = Kelas::all();
        $mengikuti = Mengikuti::where('user_id', $user_id)->pluck('kelas_id'); //Kelas yang sudah pending request
        $mendaftar = Mendaftar::where('user_id', $user_id)->pluck('kelas_id'); //Kelas yang sudah diikuti
        $notAvailable = $mengikuti->merge($mendaftar); //Kelas yang diikuti atau pending request (tidak ada button join di view)
        return view('kelas.browse')->with(
            ['kelas' => $kelas,
            'notAvailable' => $notAvailable
            ]);
    }
}
