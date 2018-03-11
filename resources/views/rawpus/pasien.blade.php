@extends('layouts.rawpus')

@section('extra-style')
<style>
    .daterangepicker{z-index:1151 !important;}
</style>
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Data Pasien</h4>
        </div>
        <div class="panel-body">
            <a class="btn btn-primary" id="tambah">
                <i class="icon-add"></i> &nbsp;
                Add New Data
            </a>

            <table class="table table-striped datatable-colvis-basic"></table>
        </div>
    </div>

    <div id='divModal'></div>
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
            var wilayah=@json($wilayah);

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
                    ajax: "{{URL::to('home/data/pasien')}}",
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'nik', name: 'nik',title:'NIK'},
                        {data: 'no_kartu', name: 'no_kartu',title:'No. Kartu'},
                        {data: 'nama_peserta', name: 'nama_peserta',title:'Nama Peserta'},
                        {data: 'sex', name: 'sex',title:'Sex'},
                        {data: 'tgl_lahir', name: 'tgl_lahir',title:'Tgl. Lahir',visibled:true},
                        {data: 'pekerjaan', name: 'pekerjaan',title:'Pekerjaan',visibled:true},
                        {data: 'alamat', name: 'alamat',title:'Alamat',visibled:true},
                        {data: 'desa.name', name: 'desa.name',title:'Desa'},
                        {data: 'action', name: 'action',title:'Action',searchable:false,width:'22%'}
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

            $(document).on("click","#tambah",function(){
                var el="";
                el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                    '<div class="modal-dialog">'+
                        '<form id="form" onsubmit="return false;" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header bg-primary">'+
                                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                    '<h5 class="modal-title" id="modal-title">Add New Data</h5>'+
                                '</div>'+

                                '<div class="modal-body">'+
                                    '<div id="pesan"></div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">NIK</label>'+
                                        '<input class="form-control" name="nik" id="nik" placeholder="NIK" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">No. Kartu</label>'+
                                        '<input class="form-control" name="no_kartu" id="no_kartu" placeholder="Name" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Nama Pasien</label>'+
                                        '<input class="form-control" name="nama" id="nama" placeholder="Name" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label">Tanggal Lahir</label>'+
                                        '<div class="input-group">'+
                                            '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                            '<input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control daterange-single">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Sex</label>'+
                                        '<select name="sex" id="sex" class="form-control" required>'+
                                            '<option value="" disabled selected>--Pilih--</option>'+
                                            '<option value="L">L</option>'+
                                            '<option value="L">P</option>'+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Golongan Darah</label>'+
                                        '<input class="form-control" name="goldar" id="goldar" placeholder="Golongan Darah" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Pekerjaan</label>'+
                                        '<input class="form-control" name="pekerjaan" id="pekerjaan" placeholder="Name" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Alamat</label>'+
                                        '<input class="form-control" name="alamat" id="alamat" placeholder="Name" required>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label text-semibold">Desa</label>'+
                                        '<select name="desa" id="desa" class="form-control" required>'+
                                            "<option value='' disabled selected>--Pilih Desa--</option>";
                                            $.each(wilayah.desa,function(a,b){
                                                el+="<option value='"+b.id+"'>"+b.name+"</option>";
                                            })
                                        el+="</select>"+
                                    '</div>'+
                                '</div>'+

                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                    '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                '</div>'+
                            '</div>'+
                        '</form>'+
                    '</div>'+
                '</div>';

                $("#divModal").empty().html(el);
                $("#modal_default").modal("show");

                $('.daterange-single').daterangepicker({ 
                    singleDatePicker: true,
                    selectMonths: true,
                    selectYears: true
                });
            });

            $(document).on("submit","#form",function(e){
                var data = new FormData(this);
                if($("#form")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('home/data/pasien')}}",
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
                                $('#pesan').empty().html('&nbsp;'+result.pesan);
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'info'
                                });
                                $("#modal_default").modal("hide");
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
            });

            $(document).on("click",".edit",function(){
                kode=$(this).attr("kode");
                var el="";

                $.ajax({
                    url:"{{URL::to('home/data/pasien')}}/"+kode,
                    type:"GET",
                    beforeSend:function(){
                        el+='<div id="modal_default" class="modal fade" data-backdrop="static" data-keyboard="false">'+
                            '<div class="modal-dialog">'+
                                '<form id="formUpdate" onsubmit="return false;" enctype="multipart/form-data">'+
                                    '<div class="modal-content">'+
                                        '<div class="modal-header bg-primary">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<h5 class="modal-title" id="modal-title">Edit Data</h5>'+
                                        '</div>'+

                                        '<div class="modal-body">'+
                                            '<div id="showForm"></div>'+
                                        '</div>'+

                                        '<div class="modal-footer">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '<button type="submit" class="btn btn-primary btn-ladda btn-ladda-spinner"id="simpan"> <span class="ladda-label">Save</span> </button>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

                        $("#divModal").empty().html(el);
                        $("#modal_default").modal("show");          
                        $("#showForm").empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                    },
                    success:function(result){
                        el+='<div id="pesan"></div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">NIK</label>'+
                            '<input class="form-control" name="nik" value="'+result.nik+'" id="nik" placeholder="NIK" required>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">No. Kartu</label>'+
                            '<input class="form-control" value="'+result.no_kartu+'" name="no_kartu" id="no_kartu" placeholder="Name" required>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Nama Pasien</label>'+
                            '<input class="form-control" value="'+result.nama_peserta+'" name="nama" id="nama" placeholder="Name" required>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label">Tanggal Lahir</label>'+
                            '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="icon-calendar5"></i></span>'+
                                '<input type="text" id="tgl_lahir"  value="'+result.tgl_lahir+'" name="tgl_lahir" class="form-control daterange-single">'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Sex</label>'+
                            '<select name="sex" id="sex" class="form-control" required>'+
                                '<option value="" disabled selected>--Pilih--</option>'+
                                '<option value="L">L</option>'+
                                '<option value="L">P</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Golongan Darah</label>'+
                            '<input class="form-control" value="'+result.golongan_darah+'" name="goldar" id="goldar" placeholder="Golongan Darah" required>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Pekerjaan</label>'+
                            '<input class="form-control" value="'+result.pekerjaan+'" name="pekerjaan" id="pekerjaan" placeholder="Name" required>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Alamat</label>'+
                            '<input class="form-control" name="alamat" value="'+result.alamat+'" id="alamat" placeholder="Name" required>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label text-semibold">Desa</label>'+
                            '<select name="desa" id="desa" class="form-control" required>'+
                                "<option value='' disabled selected>--Pilih Desa--</option>";
                                $.each(wilayah.desa,function(a,b){
                                    el+="<option value='"+b.id+"'>"+b.name+"</option>";
                                })
                            el+="</select>"+
                        '</div>';

                        $("#showForm").empty().html(el);
                        $("#sex").val(result.sex);
                        $("#desa").val(result.desa_id);
                    },
                    error:function(){
                        $("#showForm").empty().html("<div class='alert alert-danger'>Data Failed to load</div>");
                    }
                })
            });

            $(document).on("submit","#formUpdate",function(e){
                var data = new FormData(this);
                data.append("_method","PUT");
                if($("#formUpdate")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url			: "{{URL::to('home/data/pasien')}}/"+kode,
                        type		: 'post',
                        data		: data,
                        dataType	: 'JSON',
                        contentType	: false,
                        cache		: false,
                        processData	: false,
                        beforeSend	: function (){
                            $('#pesan').html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success	: function (result) {
                            if(result.success==true){
                                $('#pesan').html('&nbsp;'+result.pesan);
                                new PNotify({
                                    title: 'Info notice',
                                    text: result.pesan,
                                    addclass: 'alert-styled-left',
                                    type: 'info'
                                });
                                $("#modal_default").modal("hide");
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
            });

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
                            url:"{{URL::to('home/data/pasien')}}/"+kode,
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