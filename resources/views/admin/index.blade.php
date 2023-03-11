@extends('layouts.main', ['activePage' => '/', 'titlePage' => __('Dashboard')])
@section('title')
    Dashboard | TOKO ADRIAN
@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <div class="dropdown show">
        <a class="btn btn-primary dropdown-toggle btn-sm" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
      
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="btn btn-sm dropdown-item text-dark" data-toggle="modal" data-target="#penjualanModal"><i class="fas fa-cart-plus"></i> Penjualan</a>
          <a class="btn btn-sm dropdown-item text-dark" data-toggle="modal" data-target="#pembelianModal"><i class="fas fa-cart-arrow-down"></i> Pembelian</a>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Semua Kategori') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categories->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-list fa-2x text-info"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Semua Produk') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-box fa-2x text-info"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Semua Penjualan') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sales->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-cart-plus fa-2x text-success"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Semua Pembelian') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $purchases->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-cart-arrow-down fa-2x text-warning"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Semua Pemasok') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pemasoks->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-truck fa-2x text-info"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Semua Klien') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kliens->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-info"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('Semua Pengeluaran') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $spendmoneys->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check-alt fa-2x text-danger"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Semua Karyawan') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $moderator->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-cog fa-2x text-info"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Uang Penjualan Hari Ini') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalsaletoday, 2, ',', '.') }}.</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-angle-double-up fa-2x text-success"></i> &nbsp;
                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Keuntungan Hari Ini') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($sumprofit, 2, ',', '.') }}.</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-angle-double-up fa-2x text-success"></i> &nbsp;
                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Penjualan Hari Ini') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sales_today->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-angle-double-up fa-2x text-success"></i>
                <i class="fas fa-cart-plus fa-2x text-success"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Uang Pembelian Hari Ini') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalpurchasetoday, 2, ',', '.') }}.</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-angle-double-down fa-2x text-warning"></i> &nbsp;
                <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Pembelian Hari Ini') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $purchases_today->count() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-angle-double-down fa-2x text-warning"></i>
                <i class="fas fa-cart-arrow-down fa-2x text-warning"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('Uang Pengeluaran Hari Ini') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($spending_today, 2, ',', '.') }}.</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-angle-double-down fa-2x text-danger"></i> &nbsp;
                <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('Total Pengeluaran') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalspendmoneys, 2, ',', '.') }}.</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-angle-double-down fa-2x text-danger"></i> &nbsp;
                <i class="fas fa-money-check-alt fa-2x text-danger"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Row -->

    <div class="row">

      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Produk Terbaik Yang Dijual') }}</div>
            <div class="table-responsive">
              <table class="table table-sm" id="tabel_best_sale" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>{{ __('Nama Produk') }}</th>
                    <th>{{ __('Terjual') }}</th>
                  </tr>
                </thead>
                
                <tbody>
                  @foreach ($topsales as $index => $item)
                    <tr>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->total }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Produk Terbaik Yang Dibeli') }}</div>
            <div class="table-responsive">
              <table class="table table-sm" id="tabel_best_purchase" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>{{ __('Nama Produk') }}</th>
                    <th>{{ __('Dibeli') }}</th>
                  </tr>
                </thead>
                
                <tbody>
                  @foreach ($toppurchases as $index => $item)
                    <tr>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->total }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('Pemberitahuan Stok Produk') }}</div>
            <div class="table-responsive">
              <table class="table table-sm" id="tabel_stock_alerts" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>{{ __('Nama Produk') }}</th>
                    <th>{{ __('Stok') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($stock_alerts as $index => $stock_alert)
                    <tr>
                        <td>{{ $stock_alert->nama_produk }}</td>
                        <td><span class="badge bg-danger text-white">{{ $stock_alert->stok }}</span></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade bd-example-modal-sm" id="penjualanModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header bg-info py-3">
            <span class="m-0 font-weight-bold text-white">{{ __('Generate Report Penjualan') }}</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('report_sales') }}" method="GET">
              <div class="form-row">
                <div class="form-group col-lg-12">
                  <input class="form-control{{ $errors->has('dari_tanggal') ? ' is-invalid' : '' }}" name="dari_tanggal" type="date" placeholder="{{ __('') }}" value="{{ old('dari_tanggal') }}"/>
                  @if ($errors->has('dari_tanggal'))
                      <small class="text-danger">{{ $errors->first('dari_tanggal') }}</small>
                  @endif
                </div>
                
                <small style="color:red">NOTE:</small>&nbsp;<small>Form diatas Opsional!</small>
              </div>
          </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Tutup') }}</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> {{ __('Generate') }}</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <div class="modal fade bd-example-modal-sm" id="pembelianModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header bg-info py-3">
            <span class="m-0 font-weight-bold text-white">{{ __('Generate Report Pembelian') }}</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('report_purchases') }}" method="GET">
              <div class="form-row">
                <div class="form-group col-lg-12">
                  <input class="form-control{{ $errors->has('dari_tanggal') ? ' is-invalid' : '' }}" name="dari_tanggal" type="date" placeholder="{{ __('') }}" value="{{ old('dari_tanggal') }}"/>
                  @if ($errors->has('dari_tanggal'))
                      <small class="text-danger">{{ $errors->first('dari_tanggal') }}</small>
                  @endif
                </div>
                <small style="color:red">NOTE:</small>&nbsp;<small>Form diatas Opsional!</small>
              </div>
          </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Tutup') }}</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> {{ __('Generate') }}</button>
                </div>
            </form>
        </div>
    </div>
  </div>

@endsection

@section('scripts')

@endsection