<!DOCTYPE html>
<html>
<head>
	<title>{{ __('Laporan Penjualan') }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>{{ __('Laporan Penjualan') }}</h4>
	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor Penjualan</th>
				<th>Jumlah Total</th>
                <th>Dibayar</th>
                <th>Tunggakan</th>
                <th>Nama Pembeli</th>
                <th>Produk</th>
                <th>Jumlah</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($penjualans as $penjualan)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$penjualan->nomor_penjualan}}</td>
				<td>Rp{{ number_format($penjualan->jumlah_total, 2, ',', '.') }}.</td>
                <td>Rp{{ number_format($penjualan->dibayar, 2, ',', '.') }}.</td>
				<td>Rp{{ number_format($penjualan->due, 2, ',', '.') }}.</td>
				<td>{{$penjualan->klien->nama_klien}}</td>
				<td>
                    @foreach ($penjualan->produk as $item)
                        {{ $item->nama_produk }}
                        <br>
                    @endforeach
                </td>
				<td>
                    @foreach ($penjualan->produk as $item)
                        {{ $item->pivot->quantity }}
                        <br>
                    @endforeach
                </td>
			</tr>
            @endforeach

		</tbody>
    </table>
    <h5 style="text-align: right;">{{ __('Total Penghasilan') }} : Rp{{ number_format($totalsalemoneys, 2, ',', '.') }}.</h5>
</body>
</html>