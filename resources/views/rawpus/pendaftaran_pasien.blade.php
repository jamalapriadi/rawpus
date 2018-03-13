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
    <div class="row">
        <div id="showForm"></div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Daftar Pasien</h6>
                </div>
                <div class="panel-body">
                    <a class="btn btn-primary" id="tambah"><i class="icon-add"></i> Input Pendaftaran</a>
                    <hr>
                    <table class="table table-striped datatable-colvis-basic"></table>
                </div>
            </div>
        </div>
    </div>

    <div id="divModal"></div>
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
            var kode="";

            $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            // Setting datatable defaults
            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{ 
                    orderable: false,
                    width: '100px',
                    targets: [ 2 ]
                }],
                dom: '<"datatable-header"fCl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    $.uniform.update();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            function showData(){
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: "{{URL::to('home/data/pendaftaran')}}",
                    columns: [
                        {data: 'no_pendaftaran', name: 'no_pendaftaran',title:'No',width:'20%'},
                        {data: 'no_kartu', name: 'no_kartu',title:'No Kartu'},
                        {data: 'pasien.nama_peserta', name: 'pasien.nama_peserta',title:'Nama Peserta'},
                        {data: 'pasien.sex', name: 'pasien.sex',title:'Sex'},
                        {data: 'usia', name: 'usia',title:'Usia'},
                        {data: 'poli_tujuan', name: 'poli_tujuan',title:'Poli / Kegiatan'},
                        {data: 'status', name: 'status',title:'Status'},
                        {data: 'action', name: 'action',title:'Action',searchable:false,width:'10%'}
                    ],
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    colVis: {
                        buttonText: "<i class='icon-three-bars'></i> <span class='caret'></span>",
                        align: "right",
                        overlayFade: 200,
                        showAll: "Show all",
                        showNone: "Hide all"
                    },
                    bDestroy: true
                }); 

                // Launch Uniform styling for checkboxes
                $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
                    $('.ColVis_collection input').uniform();
                });


                // Add placeholder to the datatable filter option
                $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');


                // Enable Select2 select for the length option
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: "-1"
                }); 
            } 


            $(document).on("keypress","#pencarian",function(e){
                if(e.which == 13) {
                    var pencarian=$("#pencarian").val();

                    $.ajax({
                        url:"{{URL::to('home/data/pencarian')}}",
                        type:"GET",
                        data:"q="+pencarian,
                        beforeSend:function(){
                            $("#profilePasien").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                            $("#showParameter").empty();
                        },
                        success:function(result){
                            var el="";
                            if(result.success==true){
                                $.each(result.pasien,function(a,b){
                                    el+="<fieldset>"+
                                        "<legend>Data Pasien</legend>"+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-4 control-label">No. Kartu BPJS</label>'+
                                                '<div class="col-lg-8">'+
                                                    '<input type="hidden" name="nokartu" value="'+b.no_kartu+'">'+
                                                    b.no_kartu+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-4 control-label">Nama</label>'+
                                                '<div class="col-lg-8">'+
                                                    b.nama_peserta+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-4 control-label">Tanggal Lahir</label>'+
                                                '<div class="col-lg-8">'+
                                                    b.tgl_lahir+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-4 control-label">Kelamin</label>'+
                                                '<div class="col-lg-8">'+
                                                    b.sex+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-4 control-label">Alamat</label>'+
                                                '<div class="col-lg-8">'+
                                                    b.alamat+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-lg-4 control-label">Desa</label>'+
                                                '<div class="col-lg-8">'+
                                                    b.desa.name+
                                                '</div>'+
                                            '</div>'+
                                        '</fieldset>';
                                    
                                    var ep="";
                                    ep+='<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Jenis Kunjungan</label>'+
                                            '<div class="col-lg-8">'+
                                                '<label class="radio-inline">'+
                                                    '<input type="radio" checked="checked" name="jenis_kunjungan" value="Kunjungan Sakit"> Kunjungan Sakit'+
                                                '</label>'+
                                                '<label class="radio-inline">'+
                                                    '<input type="radio" name="jenis_kunjungan" value="Kunjungan Sehat"> Kunjungan Sehat'+
                                                '</label>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Perawatan</label>'+
                                            '<div class="col-lg-8">'+
                                                '<label class="radio-inline">'+
                                                    '<input type="radio" checked="checked" name="perawatan" value="Rawat Jalan"> Rawat Jalan'+
                                                '</label>'+
                                                '<label class="radio-inline">'+
                                                    '<input type="radio" name="perawatan" value="Rawat Inap"> Rawat Inap'+
                                                '</label>'+
                                                '<label class="radio-inline">'+
                                                    '<input type="radio" name="perawatan" value="Promotif Preventif"> Promotif Preventif'+
                                                '</label>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Poli Umum</label>'+
                                            '<div class="col-lg-4">'+
                                                '<select name="poli" class="form-control">'+
                                                    '<option value="umum">Umum</option>'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Keluhan</label>'+
                                            '<div class="col-lg-8">'+
                                                '<input class="form-control" name="keluhan">'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label"><strong>Pemeriksaan Fisik</strong></label>'+
                                            '<div class="col-lg-8">'+
                                                
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">Tinggi Badan</label>'+
                                            '<div class="col-lg-4">'+
                                                '<div class="input-group">'+
                                                    '<input class="form-control" name="tinggi_badan">'+
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
                                                    '<input class="form-control" name="berat_badan">'+
                                                    '<span class="input-group-addon">'+
                                                        'KG'+
                                                    '</span>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+

                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label"><strong>Tekanan Darah</strong></label>'+
                                            '<div class="col-lg-8">'+
                                                
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<label class="col-lg-4 control-label">- Sistole :</label>'+
                                            '<div class="col-lg-4">'+
                                                '<div class="input-group">'+
                                                    '<input class="form-control" name="sistole">'+
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
                                                    '<input class="form-control" name="diastole">'+
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
                                                    '<input class="form-control" name="respiratory">'+
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
                                                    '<input class="form-control" name="heart">'+
                                                    '<span class="input-group-addon">'+
                                                        'bpm'+
                                                    '</span>'+
                                                '</div>'+
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

            $(document).on("click","#tambah",function(){
                var el="";
                
                el+='<div class="col-lg-12">'+
                    '<div class="panel panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h6 class="panel-title">Add New</h6>'+
                        '</div>'+
                        '<form class="form-horizontal" id="form" onsubmit="return false">'+
                        '<div class="panel-body">'+
                            '<div class="row">'+
                                '<div class="col-lg-5">'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">Tgl Pendaftaran</label>'+
                                        "<div class='col-lg-8'>"+
                                            '<div class="input-group">'+
                                                '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                                '<input type="text" id="tgl_pendaftaran" name="tgl_pendaftaran" class="form-control daterange-single">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="col-lg-4 control-label">No. Pencarian</label>'+
                                        "<div class='col-lg-8'>"+
                                            '<div class="input-group">'+
                                                '<input class="form-control" name="pencarian" id="pencarian" placeholder="Cari Data">'+
                                                '<span class="input-group-addon">'+
                                                    '<a><i class="icon-search4"></i></a>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div id="profilePasien">'+
                                        
                                    '</div>'+
                                '</div>'+
                                
                                '<div class="col-lg-7">'+
                                    '<div id="showParameter"></div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div id="pesan"></div>'+
                        '<div class="panel-footer">'+
                            '<button class="btn btn-primary pull-right">Simpan</button>'+
                            '<a class="btn btn-default" id="batal">Batal</a>'+
                        '</div>'+
                        '</form>'+
                    '</div>'+
                '</div>';

                $("#showForm").empty().html(el);
                $('.daterange-single').daterangepicker({ 
                    singleDatePicker: true,
                    selectMonths: true,
                    selectYears: true
                });
                $("#pencarian").focus();
            });

            $(document).on("click","#batal",function(){
                $("#showForm").empty();
            })

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('home/data/pendaftaran')}}",
                        type		: 'post',
                        data		: data,
                        dataType	: 'JSON',
                        contentType	: false,
                        cache		: false,
                        processData	: false,
                        beforeSend	: function (){
                            $('#pesan').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success	: function (result) {
                            if(result.success==true){
                                $('#pesan').empty().html('<div class="alert alert-success">'+result.pesan+"</div>");
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'info'
                                });
                                $("#modal_default").modal("hide");
                                $("#showForm").empty();
                                showData();
                            }else{
                                $('#pesan').empty().html("<pre>"+result.error+"</pre><br>");
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'error'
                                });
                            }
                        },
                        error	:function() {  
                            $('#pesan').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            $(document).on("click",".hapus",function(){
                kode=$(this).attr("kode");

                swal({
                    title: "Are you sure?",
                    text: "You will delete data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            url:"{{URL::to('home/data/pendaftaran')}}/"+kode,
                            type:"DELETE",
                            success:function(result){
                                if(result.success=true){
                                    swal("Deleted!", result.pesan, "success");
                                    showData();
                                }else{
                                    swal("Error!", result.pesan, "error");
                                }
                            }
                        })
                    } else {
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
            });

            showData();
        })
    </script>
@endpush