<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Pasien;

class PasienController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $status=Pasien::select('id','no_kartu','nama_peserta',
            'sex','tgl_lahir','pekerjaan','alamat',
            \DB::raw('@rownum := @rownum + 1 AS no'));

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
            'nama'=>'required',
            'no_kartu'=>'required',
            'sex'=>'required',
            'tgl_lahir'=>'required',
            'pekerjaan'=>'required',
            'alamat'=>'required'
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
            $status->no_kartu=$request->input('no_kartu');
            $status->nama_peserta=$request->input('nama');
            $status->sex=$request->input('sex');
            $status->tgl_lahir=date('Y-m-d',strtotime($request->input('tgl_lahir')));
            $status->pekerjaan=$request->input('pekerjaan');
            $status->alamat=$request->input('alamat');
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
            'nama'=>'required',
            'no_kartu'=>'required',
            'sex'=>'required',
            'tgl_lahir'=>'required',
            'pekerjaan'=>'required',
            'alamat'=>'required'
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
            $status->no_kartu=$request->input('no_kartu');
            $status->nama_peserta=$request->input('nama');
            $status->sex=$request->input('sex');
            $status->tgl_lahir=date('Y-m-d',strtotime($request->input('tgl_lahir')));
            $status->pekerjaan=$request->input('pekerjaan');
            $status->alamat=$request->input('alamat');
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
}