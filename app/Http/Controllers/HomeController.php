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
        return view('rawpus.pasien');
    }
}
