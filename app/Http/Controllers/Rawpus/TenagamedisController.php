<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Tenagamedis;

class TenagamedisController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $status=Tenagamedis::select('id','jabatan_id','name',
            'alamat','no_telp',
            \DB::raw('@rownum := @rownum + 1 AS no'))
            ->with('jabatan');

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
        $rules=['name'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $status=new Tenagamedis;
            $status->jabatan_id=$request->input('jabatan');
            $status->name=$request->input('name');
            $status->alamat=$request->input('alamat');
            $status->no_telp=$request->input('telp');
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
        $jabatan=\App\Models\Rawpus\Jabatan::select('id','name')->get();
        $status=Tenagamedis::find($id);

        return array('tenaga'=>$status,'jabatan'=>$jabatan);
    }

    public function update(Request $request,$id){
        $rules=['name'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $status=Tenagamedis::find($id);
            $status->jabatan_id=$request->input('jabatan');
            $status->name=$request->input('name');
            $status->alamat=$request->input('alamat');
            $status->no_telp=$request->input('telp');
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
        $status=Tenagamedis::find($id);

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