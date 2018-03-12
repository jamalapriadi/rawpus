@extends('layouts.rawpus')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">List Kunjungan Sakit</h6>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" onsubmit="return false;">
                <div class="row well">
                    <div class="form-group">
                        <label class="col-lg-2">
                            <input type="radio" checked='checkhed' name="type" value="harian"> Harian
                        </label>
                        <div class="col-lg-4">
                            <input class="form-control daterange-single" name="harian">
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
                        <!-- <a class="btn btn-success"><i class="icon-printer4"></i> Cetak</a> -->
                    </div>
                </div>
            </form>

            <table class="table table-striped datatable-colvis-basic"></table>
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
            var bulan="{{date('m')}}";
            var tahun="{{date('Y')}}";

            $("#bulan").val(bulan);
            $("#tahun").val(tahun);

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
                    ajax: {
                        url:"{{URL::to('home/data/report/list-kunjungan')}}",
                        data:"type=Kunjungan Sakit"
                    },
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'tgl_pendaftaran', name: 'tgl_pendaftaran',title:'Tanggal',width:'20%'},
                        {data: 'pasien.no_kartu', name: 'pasien.no_kartu',title:'No. Kartu'},
                        {data: 'pasien.nama_peserta', name: 'pasien.nama_peserta',title:'Nama Peserta'},
                        {data: 'pasien.sex', name: 'pasien.sex',title:'Sex'},
                        {data: 'keluhan', name: 'keluhan',title:'Keluhan'}
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

            $(document).on("submit","#form",function(e){
                var formData = new FormData(this);
                $('.datatable-colvis-basic').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    destroy: true,
                    ajax: {
                        url:"{{URL::to('home/data/report/list-kunjungan')}}",
                        data:"type=Kunjungan Sakit"
                    },
                    columns: [
                        {data: 'no', name: 'no',title:'No.',searchable:false,width:'5%'},
                        {data: 'tgl_pendaftaran', name: 'tgl_pendaftaran',title:'Tanggal',width:'20%'},
                        {data: 'pasien.no_kartu', name: 'pasien.no_kartu',title:'No. Kartu'},
                        {data: 'pasien.nama_peserta', name: 'pasien.nama_peserta',title:'Nama Peserta'},
                        {data: 'pasien.sex', name: 'pasien.sex',title:'Sex'},
                        {data: 'keluhan', name: 'keluhan',title:'Keluhan'}
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
            })

            showData();
        })
    </script>
@endpush