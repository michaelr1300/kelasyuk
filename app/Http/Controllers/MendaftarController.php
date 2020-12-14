<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mendaftar;
use App\Models\Mengikuti;
use App\Models\Kelas;
use App\Models\User;

class MendaftarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function apply($kelas_id) //Request join kelas
    {
        $user_id = auth()->user()->id;
        $listRequest = Mendaftar::where('kelas_id', $kelas_id)->pluck('user_id');

        if( $listRequest->contains($user_id) ) //Sudah mendaftar
        {
            
        }

        else
        {
            $mendaftar = new Mendaftar;
            $mendaftar->kelas_id = $kelas_id;
            $mendaftar->user_id = $user_id;
            $mendaftar->save();
        }
        return view('home');
    }
}
