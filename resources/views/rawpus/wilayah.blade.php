@extends('layouts.rawpus')

@section('extra-style')
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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Data Wilayah</h4>
        </div>
        <div class="panel-body">
            <fieldset>
                <legend>Data Wilayah</legend>
                <table class="table table-bordered">
                    <tr>
                        <td>Kode Wilayah</td>
                        <td> : {{$wilayah->id}}</td>
                    </tr>
                    <tr>
                        <td>Nama Wilayah</td>
                        <td> : {{$wilayah->name}}</td>
                    </tr>
                </table>
            </fieldset>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width='5%'>No.</th>
                        <th>Nama Desa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=0;?>
                    @foreach($wilayah->desa as $row)
                    <?php $no++;?>
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$row->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id='divModal'></div>
@stop