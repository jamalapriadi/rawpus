<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function role(){
        return view('user.role');
    }

    public function permission($id){
        $role=Role::with('permissions')->find($id);

        return view('user.permission')
            ->with('role',$role);
    }

    public function user(){
        return view('user.user');
    }

    public function user_role($id){
        return view('user.user_role')
            ->with('id',$id);
    }

    public function rawpus_status_ketenagaan(){
        return view('rawpus.status_ketenagaan');
    }

    public function rawpus_jabatan(){
        return view('rawpus.jabatan');
    }

    public function rawpus_diagnosa(){
        return view('rawpus.diagnosa');
    }

    public function rawpus_tenaga_medis(){
        return view('rawpus.tenaga_medis');
    }

    public function rawpus_pasien(){
        $wilayah=\App\Models\Rawpus\Wilayah::with('desa')->find(3328060);

        return view('rawpus.pasien')
            ->with('wilayah',$wilayah);
    }

    public function rawpus_wilayah(){
        $wilayah=\App\Models\Rawpus\Wilayah::with('desa')->find(3328060);
        
        return view('rawpus.wilayah')
            ->with('wilayah',$wilayah);
    }

    public function rawpus_pendaftaran_pasien(){
        return view('rawpus.pendaftaran_pasien');
    }

    public function rawpus_pelayanan_pasien(){
        $tenaga=\App\Models\Rawpus\Tenagamedis::all();
        $diagnosa=\App\Models\Rawpus\Diagnosa::all();

        return view('rawpus.pelayanan_pasien')
            ->with('tenaga',$tenaga)
            ->with('diagnosa',$diagnosa);
    }

    public function rawpus_jumlah_peserta_terdaftar(){
        return view('rawpus.jumlah_peserta_terdaftar');
    }
    
    public function rawpus_daftar_kunjungan_peserta_sakit(){
        return view('rawpus.daftar_kunjungan_peserta_sakit');
    }

    public function rawpus_daftar_kunjungan_peserta_sehat(){
        return view('rawpus.daftar_kunjungan_peserta_sehat');
    }

    public function rawpus_daftar_10_diagnosa_terbanyak(){
        return view('rawpus.daftar_10_diagnosa_terbanyak');
    }

    public function rawpus_laporan_rawat_inap(){
        return view('rawpus.laporan_rawat_inap');
    }

    public function rawpus_laporan_rawat_jalan(){
        return view('rawpus.laporan_rawat_jalan');
    }
}
