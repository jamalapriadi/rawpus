<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Diagnosa;

use DB;

class ReportController extends Controller
{
    public function list_kunjungan(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));

        $pendaftaran=\App\Models\Rawpus\Pendaftaran::select(
                \DB::raw('@rownum := @rownum + 1 AS no'),
                'no_pendaftaran',
                'tgl_pendaftaran',
                'no_urut',
                'no_kartu',
                'jenis_kunjungan',
                'perawatan',
                'poli_tujuan',
                'keluhan',
                'tinggi_badan',
                'berat_badan',
                'sistole',
                'diastole',
                'respiratory_rate',
                'heart_rate'
            )->with('pasien','pelayanan','pelayanan.diagnosa');

        if($request->has('type')){
            $pendaftaran=$pendaftaran->where('jenis_kunjungan',$type);
        }

        return \DataTables::of($pendaftaran)
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->addColumn('diagnosa',function($q){
                if($q->pelayanan!=null){
                    $html=$q->pelayanan->diagnosa->diagnosa;
                }else{
                    $html="";
                }

                return $html;
            })
            ->make(true);
    }
}