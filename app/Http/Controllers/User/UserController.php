<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $user=User::select('id','name','email',
            \DB::raw('@rownum := @rownum + 1 AS no'));

        return \DataTables::of($user)
        ->addColumn('action',function($query){
            $html="<div class='btn-group'>";
            $html.="<a href='".\URL::to('home/user/'.$query->id.'/role')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Role'><i class='icon-gear'></i></a>";
            $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
            $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
            $html.="</div>";

            return $html;
        })
        ->make(true);

    }

    public function store(Request $request){
        $rules=[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'password_confirm'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $user=new User;
            $user->name=$request->input('name');
            $user->email=$request->input('email');
            $user->password=bcrypt($request->input('password'));
            
            $simpan=$user->save();

            if($simpan){
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
        }

        return $data;
    }

    public function show($id){
        $user=User::findOrFail($id);

        return array(
            'user'=>$user
        );
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required',
            'email'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $user=User::find($id);
            $user->name=$request->input('name');
            $user->email=$request->input('email');
            
            $simpan=$user->save();

            if($simpan){
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
        }

        return $data;
    }

    public function destroy($id){
        $user=User::find($id);

        $hapus=$user->delete();

        if($hapus){
            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil dihapus",
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

    public function list_role(Request $request,$id){
        $user=User::with('roles')->find($id);

        return $user;
    }

    public function save_role_user(Request $request){
        $rules=['permission'=>'required','user'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'error'=>''
            );
        }else{
            $user=User::find($request->input('user'));

            $permission=$request->input('permission');
            foreach($permission as $key=>$val){
                $user->givePermissionTo($val);
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Permission berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    public function hapus_role_user(Request $request){
        $rules=['permission'=>'required','user'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>''
            );
        }else{
            $user=User::find($request->input('user'));

            $permission=$request->input('permission');

            $user->revokePermissionTo($permission);

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil dihapus',
                'error'=>''
            );
        }
        
        return $data;
    }
}