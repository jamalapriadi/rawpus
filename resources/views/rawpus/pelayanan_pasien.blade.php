@extends('layouts.rawpus')

<style>
    fieldset{
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 20px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }	
    legend{
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 40%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #d8dfe5;
        color:#222;
    }
    .daterangepicker{z-index:1151 !important;}
</style>

@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title">Pelayanan Pasien</h6>
        </div>
        <form class="form-horizontal" name="form" id="form" onsubmit="return false;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Tgl Pendaftaran</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                    <input class="form-control daterange-single" name="tgl_pendaftaran">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Poli</label>
                            <div class="col-lg-6">
                                <select name="poli" class="form-control">
                                    <option value="umum">Umum</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Sumber Data</label>
                            <div class="col-lg-6">
                                <label class="radio-inline">
                                    <input type="radio" class="antrian" checked="checked" name="sumber" value="antrian"> No. Antrian                            
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="kartu" name="sumber" value="kartu"> No. Kartu                            
                                </label>
                            </div>
                        </div>
                        <div id="showSumber">
                            <div class="form-group">
                                <label class="col-lg-4 control-label">No. Pendaftaran</label>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input class="form-control" name="no_pendaftaran" id="no_pendaftaran">
                                        <span class="input-group-addon">
                                            <a id="cari"><i class="icon-search4"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="profilePasien">

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div id="showParameter"></div>
                    </div>
                </div>
            </div>

            <div id="pesanSukses"></div>

            <div class="panel-footer">
                <button class="btn btn-primary pull-right">Simpan</button>

                <a class="btn btn-default" id="batal">Kembali</a>
            </div>
        </form>
    </div>
@stop

@push('extra-script')
    <script type="text/javascript" src="{{URL::asset('assets/js/core/libraries/jquery_ui/datepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/core/libraries/jquery_ui/effects.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/notifications/jgrowl.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
    <script>
        $(function(){
            var tenaga=@json($tenaga);
            var diagnosa=@json($diagnosa);
            
            $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $(document).on("click",".antrian",function(){
                var el="";
                el+='<div class="form-group">'+
                    '<label class="col-lg-4 control-label">No. Pendaftaran</label>'+
                    '<div class="col-lg-6">'+
                        '<div class="input-group">'+
                            '<input class="form-control" name="no_pendaftaran" id="no_pendaftaran">'+
                            '<span class="input-group-addon">'+
                                '<a id="cari"><i class="icon-search4"></i></a>'+
                            '</span>'+
                        '</div>'+
                    '</div>'+
                '</div>';

                $("#showSumber").empty().html(el);
            })

            $(document).on("click",".kartu",function(){
                var el="";
                el+='<div class="form-group">'+
                    '<label class="col-lg-4 control-label">No. Kartu</label>'+
                    '<div class="col-lg-6">'+
                        '<div class="input-group">'+
                            '<input class="form-control" name="no_kartu" id="no_kartu">'+
                            '<span class="input-group-addon">'+
                                '<a id="cari"><i class="icon-search4"></i></a>'+
                            '</span>'+
                        '</div>'+
                    '</div>'+
                '</div>';

                $("#showSumber").empty().html(el);
            })

            $(document).on("keypress","#no_pendaftaran",function(e){
                if(e.which == 13) {
                    var pencarian=$("#no_pendaftaran").val();

                    $.ajax({
                        url:"{{URL::to('home/data/cari-pendaftaran')}}",
                        type:"GET",
                        data:"q="+pencarian+"&type=pendaftaran",
                        beforeSend:function(){
                            $("#profilePasien").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                            $("#showParameter").empty();
                            $("#pesanSukses").empty();
                        },
                        success:function(result){
                            var el="";
                            if(result.success==true){
                                $.each(result.pendaftaran,function(a,b){
                                    el+="<fieldset>"+
                                    "<legend>Data Pasien</legend>"+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">No. Kartu BPJS</label>'+
                                            '<div class="col-lg-8">'+
                                                '<input type="hidden" name="nopendaftaran" value="'+b.no_pendaftaran+'">'+
                                                b.pasien.no_kartu+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Nama</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.nama_peserta+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Tanggal Lahir</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.tgl_lahir+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Kelamin</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.sex+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Alamat</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.alamat+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Desa</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.desa.name+
                                            '</div>'+
                                        '</div>'+
                                    '</fieldset>';  

                                    var ep="";
                                    ep+='<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Poli</label>'+
                                        '<div class="col-lg-8">'+
                                            b.poli_tujuan+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Tgl. Kunjungan</label>'+
                                        '<div class="col-lg-8">'+
                                            '<div class="input-group">'+
                                                '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                                '<input type="text" value="'+b.tgl_pendaftaran+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Keluhan</label>'+
                                        '<div class="col-lg-8">'+
                                            '<input type="text" value="'+b.keluhan+'" name="keluhan" class="form-control" readonly>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Terapi</label>'+
                                        '<div class="col-lg-8">'+
                                            '<input type="text" name="terapi" class="form-control">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Diagnosa</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="diagnosa" id="diagnosa" class="form-control">'+
                                                '<option value="">--Pilih Diagnosa--</option>';
                                                $.each(diagnosa,function(g,h){
                                                    ep+="<option value='"+h.id+"'>"+h.kode_icd+" - "+h.diagnosa+"</option>";
                                                })
                                            ep+='</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label"><strong>Pemeriksaan Fisik</strong></label>'+
                                        '<div class="col-lg-8">'+
                                            
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Kesadaran</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="kesadaran" id="kesadaran" class="form-control">'+
                                                '<option value="Compos Mentis">Compos Mentis</option>'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Tinggi Badan</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" value="'+b.tinggi_badan+'" name="tinggi_badan" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'CM'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Berat Badan</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="berat_badan" value="'+b.berat_badan+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'KG'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="col-lg-4"><strong>Tekanan Darah</strong></label>'+
                                        '<div class="col-lg-8">'+
                                            
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">- Sistole :</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="sistole" value="'+b.sistole+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'mmHg'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">- Diastole :</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="diastole" value="'+b.diastole+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'mmHg'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Respiratory Rate</label>'+
                                        '<div class="col-lg-5">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="respiratory" value="'+b.respiratory_rate+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'per minute'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Heart Rate</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="heart" value="'+b.heart_rate+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'bpm'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Tenaga Medis</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="tenagamedis" id="tenagamedis" class="form-control">';
                                                $.each(tenaga, function(e,f){
                                                    ep+="<option value='"+f.id+"'>"+f.name+"</option>";
                                                })
                                            ep+='</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Status Pulang</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="status" id="status" class="form-control">'+
                                                '<option value="Sembuh">Sembuh</option>'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>';

                                    $("#showParameter").empty().html(ep);
                                })
                                
                            }else{
                                el+="<div class='alert alert-danger'>"+result.pesan+"</div>";
                            }
                            
                            $("#profilePasien").empty().html(el);
                        },
                        error:function(){
                            
                        }
                    })

                    return false;
                }
            })

            $(document).on("keypress","#no_kartu",function(e){
                if(e.which == 13) {
                    var pencarian=$("#no_kartu").val();

                    $.ajax({
                        url:"{{URL::to('home/data/cari-pendaftaran')}}",
                        type:"GET",
                        data:"q="+pencarian+"&type=nokartu",
                        beforeSend:function(){
                            $("#profilePasien").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                            $("#showParameter").empty();
                            $("#pesanSukses").empty();
                        },
                        success:function(result){
                            var el="";
                            if(result.success==true){
                                $.each(result.pendaftaran,function(a,b){
                                    el+="<fieldset>"+
                                    "<legend>Data Pasien</legend>"+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">No. Kartu BPJS</label>'+
                                            '<div class="col-lg-8">'+
                                                '<input type="hidden" name="nopendaftaran" value="'+b.no_pendaftaran+'">'+
                                                b.pasien.no_kartu+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Nama</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.nama_peserta+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Tanggal Lahir</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.tgl_lahir+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Kelamin</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.sex+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Alamat</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.alamat+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Desa</label>'+
                                            '<div class="col-lg-8">'+
                                                b.pasien.desa.name+
                                            '</div>'+
                                        '</div>'+
                                    '</fieldset>';  

                                    var ep="";
                                    ep+='<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Poli</label>'+
                                        '<div class="col-lg-8">'+
                                            b.poli_tujuan+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Tgl. Kunjungan</label>'+
                                        '<div class="col-lg-8">'+
                                            '<div class="input-group">'+
                                                '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                                '<input type="text" value="'+b.tgl_pendaftaran+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Keluhan</label>'+
                                        '<div class="col-lg-8">'+
                                            '<input type="text" value="'+b.keluhan+'" name="keluhan" class="form-control" readonly>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Terapi</label>'+
                                        '<div class="col-lg-8">'+
                                            '<input type="text" name="terapi" class="form-control">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Diagnosa</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="diagnosa" id="diagnosa" class="form-control">'+
                                                '<option value="">--Pilih Diagnosa--</option>';
                                                $.each(diagnosa,function(g,h){
                                                    ep+="<option value='"+h.id+"'>"+h.kode_icd+" - "+h.diagnosa+"</option>";
                                                })
                                            ep+='</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label"><strong>Pemeriksaan Fisik</strong></label>'+
                                        '<div class="col-lg-8">'+
                                            
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Kesadaran</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="kesadaran" id="kesadaran" class="form-control">'+
                                                '<option value="Compos Mentis">Compos Mentis</option>'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Tinggi Badan</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" value="'+b.tinggi_badan+'" name="tinggi_badan" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'CM'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Berat Badan</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="berat_badan" value="'+b.berat_badan+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'KG'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="form-group">'+
                                        '<label class="col-lg-4"><strong>Tekanan Darah</strong></label>'+
                                        '<div class="col-lg-8">'+
                                            
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">- Sistole :</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="sistole" value="'+b.sistole+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'mmHg'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">- Diastole :</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="diastole" value="'+b.diastole+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'mmHg'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Respiratory Rate</label>'+
                                        '<div class="col-lg-5">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="respiratory" value="'+b.respiratory_rate+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'per minute'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Heart Rate</label>'+
                                        '<div class="col-lg-4">'+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="heart" value="'+b.heart_rate+'" readonly>'+
                                                '<span class="input-group-addon">'+
                                                    'bpm'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Tenaga Medis</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="tenagamedis" id="tenagamedis" class="form-control">';
                                                $.each(tenaga, function(e,f){
                                                    ep+="<option value='"+f.id+"'>"+f.name+"</option>";
                                                })
                                            ep+='</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Status Pulang</label>'+
                                        '<div class="col-lg-8">'+
                                            '<select name="status" id="status" class="form-control">'+
                                                '<option value="Sembuh">Sembuh</option>'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>';

                                    $("#showParameter").empty().html(ep);
                                })
                                
                            }else{
                                el+="<div class='alert alert-danger'>"+result.pesan+"</div>";
                            }
                            
                            $("#profilePasien").empty().html(el);
                        },
                        error:function(){
                            
                        }
                    })

                    return false;
                }
            })

            $(document).on("click","#batal",function(){
                $("#profilePasien").empty();
                $("#showParameter").empty();
            })

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('home/data/pelayanan')}}",
                        type		: 'post',
                        data		: data,
                        dataType	: 'JSON',
                        contentType	: false,
                        cache		: false,
                        processData	: false,
                        beforeSend	: function (){
                            $('#pesanSukses').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success	: function (result) {
                            if(result.success==true){
                                $('#pesanSukses').empty().html('<div class="alert alert-success">'+result.pesan+"</div>");
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'info'
                                });
                                $("#modal_default").modal("hide");
                                $("#profilePasien").empty();
                                $("#showParameter").empty();
                            }else{
                                $('#pesanSukses').empty().html("<pre>"+result.error+"</pre><br>");
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'error'
                                });
                            }
                        },
                        error	:function() {  
                            $('#pesanSukses').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })
        })
    </script>
@endpush