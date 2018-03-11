<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Jabatan;

class JabatanController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $status=Jabatan::select('id','name','status_ketenagaan_id',\DB::raw('@rownum := @rownum + 1 AS no'))
            ->with('status');

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
        $rules=['name'=>'required','status'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $status=new Jabatan;
            $status->status_ketenagaan_id=$request->input('status');
            $status->name=$request->input('name');
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
        $jabatan=Jabatan::find($id);
        $status=\App\Models\Rawpus\Statusketenagaan::select('id','name')->get();

        return array('status'=>$status,'jabatan'=>$jabatan);
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
            $status=Jabatan::find($id);
            $status->status_ketenagaan_id=$request->input('status');
            $status->name=$request->input('name');
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
        $status=Jabatan::find($id);

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
}