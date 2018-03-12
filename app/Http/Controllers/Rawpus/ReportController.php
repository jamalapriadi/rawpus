<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Diagnosa;

use DB;

class ReportController extends Controller
{
    public function list_kunjungan(Request $request){
        if($request->has('type')){
            $type=$request->input('type');
        }

        $report=\DB::select("select date_format(a.tgl_pendaftaran,'%Y-%m') as bulan,
        count(a.no_pendaftaran) as total from pendaftaran a
        where a.jenis_kunjungan='$type'
        group by date_format(a.tgl_pendaftaran,'%Y-%m')");

        return $report;
    }
}