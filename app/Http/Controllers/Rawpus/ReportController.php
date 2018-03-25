<?php

namespace App\Http\Controllers\Rawpus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Rawpus\Diagnosa;

use DB;

class ReportController extends Controller
{
    public function list_kunjungan_sakit(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('jenis_kunjungan','Kunjungan Sakit')->get();

        return array(
            'data'=>$pendaftaran,
            'type'=>$request->input('type')
        );
    }

    public function cetak_daftar_kunjungan_peserta_sakit(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('jenis_kunjungan','Kunjungan Sakit')->get();

        return view('rawpus.cetak.kunjungan_sakit')
            ->with('pendaftaran',$pendaftaran);
    }

    public function list_kunjungan_sehat(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('jenis_kunjungan','Kunjungan Sehat')->get();

        return array(
            'data'=>$pendaftaran,
            'type'=>$request->input('type')
        );
    }

    public function cetak_daftar_kunjungan_peserta_sehat(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('jenis_kunjungan','Kunjungan Sehat')->get();

        return view('rawpus.cetak.kunjungan_sehat')
            ->with('pendaftaran',$pendaftaran);
    }

    public function laporan_rawat_inap(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('perawatan','Rawat Inap')->get();

        return array(
            'data'=>$pendaftaran,
            'type'=>$request->input('type')
        );
    }

    public function cetak_laporan_rawat_inap(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('perawatan','Rawat Inap')->get();

        return view('rawpus.cetak.laporan_rawat_inap')
            ->with('pendaftaran',$pendaftaran);
    }

    public function laporan_rawat_jalan(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('perawatan','Rawat Jalan')->get();

        return array(
            'data'=>$pendaftaran,
            'type'=>$request->input('type')
        );
    }

    public function cetak_laporan_rawat_jalan(Request $request){
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
            $type=$request->input('type');
            switch($type){
                case 'harian':
                        if($request->has('harian')){
                            $hari=date('Y-m-d',strtotime($request->input('harian')));

                            $pendaftaran=$pendaftaran->where('tgl_pendaftaran',$hari);
                        }
                    break;
                case 'bulanan':
                        if($request->has('bulan')){
                            $bulan=$request->input('bulan');
                        }else{
                            $bulan=date('m');
                        }

                        if($request->has('tahun')){
                            $tahun=$request->input('tahun');
                        }else{
                            $tahun=date('Y');
                        }

                        $pendaftaran=$pendaftaran->where(\DB::raw("date_format(tgl_pendaftaran,'%Y-%d')"),$tahun."-".$bulan);
                    break;
                case 'individu':
                        if($request->input('individu')){
                            $pasien=$request->input('individu');

                            $pendaftaran=$pendaftaran->whereHas('pasien',function($q) use($pasien){
                                $q->where('no_kartu',$pasien)
                                    ->orWhere('nama_peserta','like','%'.$pasien.'%')
                                    ->orWhere('nik',$pasien);
                            });
                        }
                    break;
            }
        }

        $pendaftaran=$pendaftaran->where('perawatan','Rawat Jalan')->get();

        return view('rawpus.cetak.laporan_rawat_jalan')
            ->with('pendaftaran',$pendaftaran);
    }

    public function jumlah_peserta_terdaftar(Request $request){
        if($request->has('bulan')){
            $bulan=$request->input('bulan');
        }else{
            $bulan=date('m');
        }

        if($request->has('tahun')){
            $tahun=date('Y',strtotime($request->input('tahun')));
        }else{
            $tahun=date('Y');
        }

        $all=$tahun."-".$bulan;

        $jumlah=\DB::select("select DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m') as tanggal,
            count(a.no_kartu) as jumlah
            from pendaftaran a 
            where DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m')='$all'
            group by DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m'),a.no_kartu");

        return array('data'=>$jumlah,'all'=>$all);
    }

    public function daftar_10_diagnosa_terbanyak(Request $request){
        if($request->has('bulan')){
            $bulan=$request->input('bulan');
        }else{
            $bulan=date('m');
        }

        if($request->has('tahun')){
            $tahun=date('Y',strtotime($request->input('tahun')));
        }else{
            $tahun=date('Y');
        }

        $all=$tahun."-".$bulan;

        $jumlah=\DB::select("select date_format(a.tgl_pendaftaran,'%Y-%m') as tanggal, b.diagnosa,
            count(a.diagnosa_id) as jumlah
            from pelayanan a 
            left join diagnosa b on b.id=a.diagnosa_id
            where DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m')='$all'
            group by date_format(a.tgl_pendaftaran,'%Y-%m'), a.diagnosa_id");
        
        return array('data'=>$jumlah,'all'=>$all);
    }

    public function cetak_daftar_10_diagnosa_terbanyak(Request $request){
        if($request->has('bulan')){
            $bulan=$request->input('bulan');
        }else{
            $bulan=date('m');
        }

        if($request->has('tahun')){
            $tahun=date('Y',strtotime($request->input('tahun')));
        }else{
            $tahun=date('Y');
        }

        $all=$tahun."-".$bulan;

        $jumlah=\DB::select("select date_format(a.tgl_pendaftaran,'%Y-%m') as tanggal, b.diagnosa,
            count(a.diagnosa_id) as jumlah
            from pelayanan a 
            left join diagnosa b on b.id=a.diagnosa_id
            where DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m')='$all'
            group by date_format(a.tgl_pendaftaran,'%Y-%m'), a.diagnosa_id");
        
        return view('rawpus.cetak.daftar_10_diagnosa_terbanyak')
            ->with('data',$jumlah)
            ->with('all',$all);
    }

    public function cari_list_kunjungan(Request $request){
        return array(
            'success'=>true,
            'pesan'=>'Load sukses',
            'input'=>$request->all()
        );
    }

    public function cetak_jumlah_peserta_terdaftar(Request $request){
        if($request->has('bulan')){
            $bulan=$request->input('bulan');
        }else{
            $bulan=date('m');
        }

        if($request->has('tahun')){
            $tahun=date('Y',strtotime($request->input('tahun')));
        }else{
            $tahun=date('Y');
        }

        $all=$tahun."-".$bulan;

        $jumlah=\DB::select("select DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m') as tanggal,
            count(a.no_kartu) as jumlah
            from pendaftaran a 
            where DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m')='$all'
            group by DATE_FORMAT(a.tgl_pendaftaran,'%Y-%m'),a.no_kartu");

        return view('rawpus.cetak.jumlah_peserta_terdaftar')
            ->with('data',$jumlah)
            ->with('all',$all);
    }
}