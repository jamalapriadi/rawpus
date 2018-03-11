@extends('layouts.rawpus')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Pelayanan Pasien</h6>
        </div>

        <div class="panel-body">
            <form class="form-horizontal">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Tgl Pendaftaran</label>
                            <div class="col-lg-6">
                                <input class="form-control daterange-single" name="tgl_pendaftaran">
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
                        <div class="showProfile">

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Poli</label>
                            <div class="col-lg-8">
                                <div id="showPoli"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Tgl. Kunjungan</label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon-calendar5"></i></span>
                                    <input type="text" id="tgl_pendaftaran" name="tgl_pendaftaran" class="form-control daterange-single">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Keluhan</label>
                            <div class="col-lg-8">
                                <input type="text" name="keluhan" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Terapi</label>
                            <div class="col-lg-8">
                                <input type="text" name="terapi" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Diagnosa</label>
                            <div class="col-lg-8">
                                <input type="text" name="terapi" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label"><strong>Pemeriksaan Fisik</strong></label>
                            <div class="col-lg-8">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Tinggi Badan</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input class="form-control" name="tinggi_badan">
                                    <span class="input-group-addon">
                                        CM
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Berat Badan</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input class="form-control" name="berat_badan">
                                    <span class="input-group-addon">
                                        KG
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label"><strong>Tekanan Darah</strong></label>
                            <div class="col-lg-8">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">- Sistole :</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input class="form-control" name="sistole">
                                    <span class="input-group-addon">
                                        mmHg
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">- Diastole :</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input class="form-control" name="diastole">
                                    <span class="input-group-addon">
                                        mmHg
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Respiratory Rate</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input class="form-control" name="diastole">
                                    <span class="input-group-addon">
                                        per minute
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Heart Rate</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input class="form-control" name="diastole">
                                    <span class="input-group-addon">
                                        bpm
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
        })
    </script>
@endpush