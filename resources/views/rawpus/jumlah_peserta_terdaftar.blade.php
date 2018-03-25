@extends('layouts.rawpus')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Jumlah Peserta Terdaftar</h6>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="forms" action="{{URL::to('home/data/report/cetak-jumlah-peserta-terdaftar')}}" method="post" target="new target">
                <div class="row well">
                    <div class="form-group">
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
                        <div class="col-lg-4">
                            <a class="btn btn-primary" style="margin-top:5px" id="tampilkan"><i class="icon-search4"></i> Cari Data</a>
                            <button style="margin-top:5px" class="btn btn-success"><i class="icon-printer4"></i> Cetak</button>
                        </div>
                    </div>
                </div>
            </form>

            <div id="tampilData"></div>
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
                var formData = new FormData($('#forms')[0]);

                $.ajax({
                    url:"{{URL::to('home/data/report/jumlah-pasien-terdaftar')}}",
                    type:"POST",
                    data:formData,
                    dataType    : 'JSON',
                    contentType : false,
                    cache       : false,
                    processData : false,
                    beforeSend:function(){
                        $("#tampilData").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped datatable-colvis-basic'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th width='5%'>No.</th>"+
                                    "<th width='25%'>Tanggal</th>"+
                                    "<th>Jumlah</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                                var no=0;
                                $.each(result.data,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+b.tanggal+"</td>"+
                                        "<td>"+b.jumlah+"</td>"+
                                    "</tr>";
                                })
                        el+="</tbody>"+
                        "</table>";

                        $("#tampilData").empty().html(el);

                        $('.datatable-colvis-basic').DataTable({
                            destroy: true,
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
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#forms",function(e){
                var formData = new FormData($('#forms')[0]);
                
            })

            $(document).on("click","#tampilkan",function(e){
                var formData = new FormData($('#forms')[0]);
                
                $.ajax({
                    url:"{{URL::to('home/data/report/jumlah-pasien-terdaftar')}}",
                    type:"POST",
                    data:formData,
                    dataType    : 'JSON',
                    contentType : false,
                    cache       : false,
                    processData : false,
                    beforeSend:function(){
                        $("#tampilData").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        el+="<table class='table table-striped datatable-colvis-basic'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th width='5%'>No.</th>"+
                                    "<th width='25%'>Tanggal</th>"+
                                    "<th>Jumlah</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";
                                var no=0;
                                $.each(result.data,function(a,b){
                                    no++;
                                    el+="<tr>"+
                                        "<td>"+no+"</td>"+
                                        "<td>"+b.tanggal+"</td>"+
                                        "<td>"+b.jumlah+"</td>"+
                                    "</tr>";
                                })
                        el+="</tbody>"+
                        "</table>";

                        $("#tampilData").empty().html(el);

                        $('.datatable-colvis-basic').DataTable({
                            destroy: true,
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
                    },
                    error:function(){

                    }
                })
            })

            showData();
        })
    </script>
@endpush