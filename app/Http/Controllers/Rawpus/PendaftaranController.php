<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Pendaftaran;
use DB;
class PendaftaranController extends Controller
{
    public function index(Request $request){
        
    }

    public function store(Request $request){
        $rules=[
            'nokartu'=>'required',
            'tgl_pendaftaran'=>'required',
            'jenis_kunjungan'=>'required',
            'perawatan'=>'required',
            'poli'=>'required',
            'keluhan'=>'required',
            'tinggi_badan'=>'required',
            'berat_badan'=>'required',
            'sistole'=>'required',
            'diastole'=>'required',
            'respiratory'=>'required',
            'heart'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $nopendaftaran=$this->autoNumber("pendaftaran","no_pendaftaran","A-");

            $pendaftaran=new \App\Models\Rawpus\Pendaftaran;
            $pendaftaran->no_pendaftaran=$nopendaftaran;
            $pendaftaran->no_urut=null;
            $pendaftaran->tgl_pendaftaran=date('Y-m-d',strtotime($request->input('tgl_pendaftaran')));
            $pendaftaran->no_kartu=$request->input('nokartu');
            $pendaftaran->jenis_kunjungan=$request->input('jenis_kunjungan');
            $pendaftaran->perawatan=$request->input('perawatan');
            $pendaftaran->poli_tujuan=$request->input('poli');
            $pendaftaran->keluhan=$request->input('keluhan');
            $pendaftaran->tinggi_badan=$request->input('tinggi_badan');
            $pendaftaran->berat_badan=$request->input('berat_badan');
            $pendaftaran->sistole=$request->input('sistole');
            $pendaftaran->diastole=$request->input('diastole');
            $pendaftaran->respiratory_rate=$request->input('respiratory');
            $pendaftaran->heart_rate=$request->input('heart');
            $pendaftaran->insert_user=\Auth::user()->email;
            $pendaftaran->update_user=null;
            $pendaftaran->save();
            $data=array(
                'success'=>true,
                'pesan'=>"Data Berhasil disimpan",
                'error'=>''
            );
        }

        return $data;
    }

    public function autoNumber($table,$primary,$prefix){
        $q=DB::table($table)->select(DB::raw('MAX(RIGHT('.$primary.',3)) as kd_max'));
        $prx=$prefix;
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $kd = $prx.sprintf("%04s", $tmp);
            }
        }
        else
        {
            $kd = $prx."0001";
        }
 
        return $kd;
    }

    public function show($id){

    }

    public function update(Request $request,$id){

    }

    public function destroy($id){

    }
}