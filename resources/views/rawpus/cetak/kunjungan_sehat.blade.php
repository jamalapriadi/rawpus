<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{ Html::style('klorofil/css/cosmo.min.css')}}
    <title>Laporan Kunjungan Sehat</title>
</head>
<body onload="window.print();">
    <table class='table table-striped datatable-colvis-basic'>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Pendaftaran</th>
                <th>Tgl Pendaftaran</th>
                <th>No. Kartu</th>
                <th>Nama Peserta</th>
                <th>Sex</th>
                <th>Keluhan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=0;?>
            @foreach($pendaftaran as $row)
                <?php $no++;?>
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$row->no_pendaftaran}}</td>
                    <td>{{$row->tgl_pendaftaran}}</td>
                    <td>{{$row->pasien->no_kartu}}</td>
                    <td>{{$row->pasien->nama_peserta}}</td>
                    <td>{{$row->pasien->sex}}</td>
                    <td>{{$row->keluhan}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>