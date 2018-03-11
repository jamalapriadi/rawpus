<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Pasien;
use DB;
class PasienController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $status=Pasien::select('id','nik','no_kartu','nama_peserta',
            'sex','tgl_lahir','pekerjaan','alamat','golongan_darah','desa_id',
            \DB::raw('@rownum := @rownum + 1 AS no'))
            ->with('desa');

        return \DataTables::of($status)
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'nik'=>'required',
            'nama'=>'required',
            'no_kartu'=>'required',
            'sex'=>'required',
            'tgl_lahir'=>'required',
            'pekerjaan'=>'required',
            'alamat'=>'required',
            'goldar'=>'required',
            'desa'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $status=new Pasien;
            $status->nik=$request->input('nik');
            $status->no_kartu=$request->input('no_kartu');
            $status->nama_peserta=$request->input('nama');
            $status->sex=$request->input('sex');
            $status->tgl_lahir=date('Y-m-d',strtotime($request->input('tgl_lahir')));
            $status->golongan_darah=$request->input('goldar');
            $status->pekerjaan=$request->input('pekerjaan');
            $status->alamat=$request->input('alamat');
            $status->desa_id=$request->input('desa');
            $status->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    public function show($id){
        $status=Pasien::find($id);

        return $status;
    }

    public function update(Request $request,$id){
        $rules=[
            'nik'=>'required',
            'nama'=>'required',
            'no_kartu'=>'required',
            'sex'=>'required',
            'tgl_lahir'=>'required',
            'pekerjaan'=>'required',
            'alamat'=>'required',
            'goldar'=>'required',
            'desa'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $status=Pasien::find($id);
            $status->nik=$request->input('nik');
            $status->no_kartu=$request->input('no_kartu');
            $status->nama_peserta=$request->input('nama');
            $status->sex=$request->input('sex');
            $status->tgl_lahir=date('Y-m-d',strtotime($request->input('tgl_lahir')));
            $status->golongan_darah=$request->input('goldar');
            $status->pekerjaan=$request->input('pekerjaan');
            $status->alamat=$request->input('alamat');
            $status->desa_id=$request->input('desa');
            $status->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    public function destroy($id){
        $status=Pasien::find($id);

        $hapus=$status->delete();

        if($hapus){
            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil dihapus',
                'error'=>''
            );
        }else{
            $data=array(
                'success'=>false,
                'pesan'=>'Data gagal dihapus',
                'error'=>''
            );
        }

        return $data;
    }

    public function list_jabatan(Request $request){
        $status=\App\Models\Rawpus\Jabatan::select('id','name')->get();

        return $status;
    }

    public function list_wilayah(Request $request){
        $wilayah=\App\Models\Rawpus\Desa::where('wilayah_id',3328060)->get();

        return $wilayah;
    }

    public function list_pencarian(Request $request){
        $rules=[
            'q'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>"Validasi Gagal",
                'error'=>''
            );
        }else{
            $q=$request->input('q');

            $pasien=Pasien::where('nik',$q)
                ->orWhere('no_kartu',$q)
                ->with('desa')
                ->get();

            if(count($pasien)>0){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil ditemukan',
                    'pasien'=>$pasien
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data tidak ditemukan',
                    'error'=>''
                );
            }
        }

        return $data;
    }
}