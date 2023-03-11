<!DOCTYPE html>
<html>
<head>
	<title>{{ __('Laporan Pembelian') }}</title>
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
		<h5>{{ __('Laporan Pembelian') }}</h4>
	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor Pembelian</th>
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
			@foreach($pembelians as $pembelian)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$pembelian->nomor_pembelian}}</td>
				<td>Rp{{ number_format($pembelian->jumlah_total, 2, ',', '.') }}.</td>
                <td>Rp{{ number_format($pembelian->dibayar, 2, ',', '.') }}.</td>
				<td>Rp{{ number_format($pembelian->due, 2, ',', '.') }}.</td>
				<td>{{$pembelian->pemasok->nama_pemasok}}</td>
				<td>
                    @foreach ($pembelian->produk as $item)
                        {{ $item->nama_produk }}
                        <br>
                    @endforeach
                </td>
				<td>
                    @foreach ($pembelian->produk as $item)
                        {{ $item->pivot->quantity }}
                        <br>
                    @endforeach
                </td>
			</tr>
            @endforeach

		</tbody>
    </table>
    <h5 style="text-align: right;">{{ __('Total Pembelian') }} : Rp{{ number_format($totalpurchasemoneys, 2, ',', '.') }}.</h5>
</body>
</html>