<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Pelayanan;
use DB;
class PelayananController extends Controller
{
    public function index(Request $request){

    }

    public function store(Request $request){
        $rules=[
            'no_pendaftaran'=>'required',
            'poli'=>'required',
            'sumber'=>'required',
            'tgl_pendaftaran'=>'required',
            'keluhan'=>'required',
            'terapi'=>'required',
            'diagnosa'=>'required',
            'kesadaran'=>'required',
            'tenagamedis'=>'required',
            'status'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $p=new Pelayanan;
            $p->tgl_pendaftaran=date('Y-m-d',strtotime($request->input('tgl_pendaftaran')));
            $p->poli=$request->input('poli');
            $p->sumber_data=$request->input('sumber');
            $p->no_pendaftaran_atau_kartu=$request->input('no_pendaftaran');
            $p->terapi=$request->input('terapi');
            $p->diagnosa_id=$request->input('diagnosa');
            $p->kesadaran=$request->input('kesadaran');
            $p->tenaga_medis_id=$request->input('tenagamedis');
            $p->status_pulang=$request->input('status');
            $p->insert_user=\Auth::user()->email;
            $p->update_user=\Auth::user()->email;
            $p->save();

            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil disimpan",
                'error'=>''
            );
        }

        return $data;
    }
}