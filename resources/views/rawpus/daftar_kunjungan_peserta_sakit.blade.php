@extends('layouts.rawpus')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">List Kunjungan Sakit</h6>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="row well">
                    <div class="form-group">
                        <label class="col-lg-2">
                            <input type="radio" checked='checkhed' name="type" value="harian"> Harian
                        </label>
                        <div class="col-lg-4">
                            <input class="form-control" name="harian">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2">
                            <input type="radio" name="type" value="bulanan"> Bulanan
                        </label>
                        <div class="col-lg-2">
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">Mei</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Ags</option>
                                <option value="09">Sep</option>
                                <option value="10">Okt</option>
                                <option value="11">Nov</option>
                                <option value="12">Des</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select name="tahun" id="tahun" class="form-control">
                                @for($tahun=2015;$tahun<=date('Y');$tahun++)
                                    <option value="{{$tahun}}">{{$tahun}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2">
                            <input type="radio" name="type" value="individu"> Individu
                        </label>
                        <div class='col-lg-4'>
                            <input class="form-control" name="individu">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2"></label>
                        <button class="btn btn-primary"><i class="icon-search4"></i> Cari Data</button>
                        <a class="btn btn-success"><i class="icon-printer4"></i> Cetak</a>
                    </div>
                </div>
            </form>

            <div id="tampilData"></div>
        </div>
    </div>
@stop

@push('extra-script')
    <script>
        $(function(){
            var bulan="{{date('m')}}";
            var tahun="{{date('Y')}}";

            $("#bulan").val(bulan);
            $("#tahun").val(tahun);

            function showData(){
                $.ajax({
                    url:"{{URL::to('home/data/report/list-kunjungan')}}",
                    type:"GET",
                    data:"type=Kunjungan Sehat",
                    beforeSend:function(){
                        $("#tampilData").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<hr><div class='table-responsive'><table class='table table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>No.</th>"+
                                    "<th>Tanggal</th>"+
                                    "<th>No. Kartu</th>"+
                                    "<th>Nama Peserta</th>"+
                                    "<th>Sex</th>"+
                                    "<th>Jenis Peserta</th>"+
                                    "<th>Diagnosa</th>"+
                                    "<th>Dirujuk</th>"+
                                    "<th>Cetak</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                                // $.each(result,function(a,b){
                                //     el+="<tr>"+
                                //         "<td>"+b.bulan+"</td>"+
                                //         "<td>"+b.total+"</td>"+
                                //     "</tr>";
                                // })
                            el+="</tbody>"+
                        '</table></div>';

                        $("#tampilData").empty().html(el);
                    },
                    error:function(){

                    }
                })
            }

            showData();
        })
    </script>
@endpush