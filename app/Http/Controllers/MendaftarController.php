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
        $listJoin = Mengikuti::where('kelas_id', $kelas_id)->pluck('user_id');

        if( $listRequest->contains($user_id) ) //Sudah daftar (pending request)
        {
            return back();
            //return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda sudah meminta bergabung!');
        }

        elseif( $listJoin->contains($user_id) ) //Sudah gabung kelas
        {
            return redirect()->action([KelasController::class, 'index'])->with('error', 'Anda sudah tergabung di kelas tersebut!');
        }

        else
        {
            $mendaftar = new Mendaftar;
            $mendaftar->kelas_id = $kelas_id;
            $mendaftar->user_id = $user_id;
            $mendaftar->save();
            return redirect()->action([KelasController::class, 'browse']);
        }
    }

    public function response(Request $request) //Accept atau Deny request join kelas
    {
        if (auth()->user()->role === 2) //Guru
        {
            //Checkbox yang dicentang
            $apply_ids = $request->input('apply_ids');         

            //Ada minimal 1 checkbox dicentang
            if ($apply_ids != NULL)
            {
                //Cek button yang ditekan
                switch ($request->input('action'))
                {
                    case 'accept':
                        foreach ($apply_ids as $apply_id) 
                        { 
                            $daftar = Mendaftar::find($apply_id);
                            $kelas = Kelas::find($daftar->kelas_id);
                            
                            //Guru yang punya kelas, bisa acc
                            if ( $kelas->user_id === auth()->user()->id)
                            {
                                //Murid diterima, data murid didaftarkan ke anggota kelas
                                $mengikuti = new Mengikuti;
                                $mengikuti->user_id = $daftar->user_id;
                                $mengikuti->kelas_id = $daftar->kelas_id;
                                $mengikuti->save();

                                //Pending request dihapus
                                $daftar->delete();
                            }
                        }
                        break;
            
                    case 'deny':
                        foreach ($apply_ids as $apply_id) 
                        { 
                            $daftar = Mendaftar::find($apply_id);
                            $kelas = Kelas::find($daftar->kelas_id);
                            
                            //Guru yang punya kelas, bisa deny
                            if ( $kelas->user_id === auth()->user()->id)
                            {
                                //Pending request dihapus
                                $daftar->delete();
                            }
                        }
                        break;
                }
            }
            return back();
        }
    }
}
