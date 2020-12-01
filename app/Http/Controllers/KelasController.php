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
            foreach ($kelas as $kelas)
            {
                $kelas->push(Kelas::find($mengikutis->kelas_id));
            }
        }

        if (auth()->user()->role === 2) //Guru
        {
            //$mengajars = Mengajar::where('user_id', $id)->get();
            $buatKelas = Kelas::where('user_id', $id)->get();
            $kelas = collect([]);
            foreach ($kelas as $kelas)
            {
                $kelas->push(Kelas::find($buatKelas->kelas_id));
            }
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
        if (auth()->user()->role === 2)
        {
            return view('kelas.create');
        }
        else
        {
            return redirect()->action([KelasController::class, 'index']);
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
        //
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
