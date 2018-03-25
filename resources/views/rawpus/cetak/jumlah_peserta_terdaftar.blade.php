<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{ Html::style('klorofil/css/cosmo.min.css')}}
    <title>Laporan Jumlah Peserta Terdaftar</title>
</head>
<body onload="window.print();">
    <table class='table table-striped datatable-colvis-basic'>
        <thead>
            <tr>
                <th width='5%'>No.</th>
                <th width='25%'>Tanggal</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=0;?>
            @foreach($data as $row)
                <?php $no++;?>
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$row->tanggal}}</td>
                    <td>{{$row->jumlah}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>