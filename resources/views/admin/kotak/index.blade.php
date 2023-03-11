@extends('layouts.main', ['activePage' => 'kotakuang', 'titlePage' => __('Kotak Uang')])
@section('title')
    {{ __('Kotak Uang | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-primary py-3">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Kotak Uang') }}</h5>
      </div>

      <div class="card-body">
        @include('layouts.flash')
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_kotak" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>{{ __('Nama Transaksi') }}</th>
                <th>{{ __('Tipe Transaksi') }}</th>
                <th>{{ __('Masukan dan Pengeluaran') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($uangpenjualan as $index => $uangpenjualan)
                <tr>
                    <td><span class="badge bg-success text-white">{{ $index + 1 }}- {{ __('Penjualan') }}</span></td>
                    <td><span class="badge bg-success text-white">{{ $uangpenjualan->nomor_penjualan }}</span></td>
                    <td><span class="badge bg-success text-white">Rp{{ number_format($uangpenjualan->dibayar, 2, ',', '.') }}.</span></td>
                </tr>
                @endforeach
                @foreach ($uangpembelian as $index => $uangpembelian)
                <tr>
                    <td><span style="color: black;" class="badge bg-warning">{{ $index + 1 }}- {{ __('Pembelian') }}</span>
                    </td>
                    <td><span style="color: black;" class="badge bg-warning">{{ $uangpembelian->nomor_pembelian }}</span></td>
                    <td><span style="color: black;" class="badge bg-warning">Rp{{ number_format($uangpembelian->dibayar, 2, ',', '.') }}.</span></td>
                </tr>
                @endforeach
                @foreach ($uangpengeluaran as $index => $uangpengeluaran)
                <tr>
                    <td><span class="badge bg-danger text-white">{{ $index + 1 }}- {{ __('Pengeluaran') }}</span>
                    </td>
                    <td><span class="badge bg-danger text-white">{{ $uangpengeluaran->nama_pengeluaran }}</span>
                    </td>
                    <td><span class="badge bg-danger text-white">Rp{{ number_format($uangpengeluaran->harga_pengeluaran, 2, ',', '.') }}.</span></td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header bg-primary py-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-success col-md-12 text-white">{{ __('Total Dana Penjualan') }} :
                            Rp{{ number_format($totaluangpenjualan, 2, ',', '.') }}.</span></h4>
                    </div>
                    <div class="text-center">
                        <h4 style="color: black;"><span class="badge p-2 bg-warning col-md-12">{{ __('Total Dana Pembelian')}} :
                            Rp{{ number_format($totaluangpembelian, 2, ',', '.') }}.</span>
                        </h4>
                    </div>
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-danger col-md-12 text-white">{{ __('Total Hutang Klien') }} :
                            Rp{{ number_format($totaluanghutangpenjualan, 2, ',', '.') }}.</span>
                        </h4>
                    </div>
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-danger col-md-12 text-white">{{ __('Total Hutang Saya') }} :
                            Rp{{ number_format($totaluanghutangpembelian, 2, ',', '.') }}.</span>
                        </h4>
                    </div>
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-danger col-md-12 text-white">{{ __('Total Pengeluaran') }} :
                            Rp{{ number_format($totaluangpengeluaran, 2, ',', '.') }}.</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 style="color: black;"><span class="badge bg-white col-md-12">{{ __('Total Kotak Uang') }} :
                        Rp{{ number_format($totalkotakuang, 2, ',', '.') }}.</span></h1>
                </div>
            </div>
        </div>
    </div>
</div>
  
@endsection

@section('scripts')

@endsection