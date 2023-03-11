@extends('layouts.main', ['activePage' => 'pemasok', 'titlePage' => __('Detail Pembelian')])
@section('title')
    {{ __('Detail Pembelian | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-primary py-3">
        <form action="{{ route('pembelian.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Detail Pembelian') }} {{ $pemasok->nama_pemasok }}
            
        </h5>
        </form>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_pembelian" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">{{ __('No.') }}</th>
                <th>{{ __('Nomor Pembelian') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Diskon') }}</th>
                <th>{{ __('Jumlah Total') }}</th>
                <th>{{ __('Dibayar') }}</th>
                <th>{{ __('Hutang') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($pemasok->pembelian as $index => $pembelian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pembelian->nomor_pembelian }}</td>
                    @if ($pembelian->status == "dibayar")
                    <td>
                        <span class="badge bg-success text-white">LUNAS</span>
                    </td>
                    @endif
                    @if ($pembelian->status == "tidak dibayar")
                    <td>
                        <span class="badge bg-danger text-white">TIDAK DIBAYAR</span>
                    </td>
                    @endif
                    @if ($pembelian->status == "hutang")
                    <td>
                        <span class="badge bg-warning text-white">HUTANG</span>
                    </td>
                    @endif
                    <td>Rp{{ number_format($pembelian->total, 2, ',', '.') }}.</td>
                    <td>Rp{{ number_format($pembelian->diskon, 2, ',', '.') }}.</td>
                    <td>Rp{{ number_format($pembelian->jumlah_total, 2, ',', '.') }}.</td>
                    <td>Rp{{ number_format($pembelian->dibayar, 2, ',', '.') }}.</td>
                    @if ($pembelian->status == "dibayar")
                    <td>
                        <span class="badge bg-success text-white">Rp{{ number_format($pembelian->due, 2, ',', '.') }}.</span>
                    </td>
                    @endif
                    @if ($pembelian->status == "tidak dibayar")
                    <td>
                        <span class="badge bg-danger text-white">Rp{{ number_format($pembelian->due, 2, ',', '.') }}.</span>
                    </td>
                    @endif
                    @if ($pembelian->status == "hutang")
                    <td>
                        <span class="badge bg-warning text-white">Rp{{ number_format($pembelian->due, 2, ',', '.') }}.</span>
                    </td>
                    @endif
                    <td>
                        <button style="width: 80px" type="" class="btn btn-info btn-sm text-white"
                            data-toggle="modal" data-target="#showModal{{ $pembelian->id }}">
                                <i class="fas fa-eye"></i> {{ __('Detail') }}</button>
                                <div class="modal fade bd-example-modal-lg" id="showModal{{ $pembelian->id }}" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-info py-3">
                                            <span class="m-0 font-weight-bold text-white">Detail {{ $pembelian->nomor_pembelian }}</span>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Nomor Pembelian</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>{{ $pembelian->nomor_pembelian }}</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-3">
                                                    <p>Status</p>
                                                </div>
                                                <div class="form-group col-lg-0">
                                                    <p>:</p>
                                                </div>
                                                <div class="form-group col-lg-8">
                                                    @if ($pembelian->status == "dibayar")
                                                    
                                                        <span class="badge bg-success text-white">LUNAS</span>
                                                    
                                                    @endif
                                                    @if ($pembelian->status == "tidak dibayar")
                                                    
                                                        <span class="badge bg-danger text-white">TIDAK DIBAYAR</span>
                                                    
                                                    @endif
                                                    @if ($pembelian->status == "hutang")
                                                    
                                                        <span class="badge bg-warning text-white">HUTANG</span>
                                                    
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-3">
                                                    <p>Pembeli</p>
                                                </div>
                                                <div class="form-group col-lg-0">
                                                    <p>:</p>
                                                </div>
                                                <div class="form-group col-lg-8">
                                                    <span>{{ $pembelian->pemasok->nama_pemasok }}</span>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-3">
                                                  <p>Produk & Jumlah</p>
                                                </div>
                                                <div class="form-group col-lg-0">
                                                  <p>:</p>
                                                </div>
                                                <div class="form-group col-lg-8">
                                                    <span>
                                                        @foreach ($pembelian->produk as $item)
                                                            {{ $item->nama_produk }} [{{ $item->pivot->quantity }}] = Rp{{ number_format($item->harga_pembelian * $item->pivot->quantity, 2, ',', '.') }}.
                                                            <br>
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </div>                          
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Total</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>Rp{{ number_format($pembelian->total, 2, ',', '.') }}.</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Diskon</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>Rp{{ number_format($pembelian->diskon, 2, ',', '.') }}.</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Jumlah Total</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>Rp{{ number_format($pembelian->jumlah_total, 2, ',', '.') }}.</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-3">
                                                  <p>Dibayar</p>
                                                </div>
                                                <div class="form-group col-lg-0">
                                                  <p>:</p>
                                                </div>
                                                <div class="form-group col-lg-8">
                                                  <span>Rp{{ number_format($pembelian->dibayar, 2, ',', '.') }}.</span>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Hutang</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                @if ($pembelian->due == 0)
                                                    <span class="badge bg-success text-white">Rp{{ number_format($pembelian->due, 2, ',', '.') }}.</span>
                                                @else
                                                    <span class="badge bg-danger text-white">Rp{{ number_format($pembelian->due, 2, ',', '.') }}.</span>
                                                @endif
                                              </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-3">
                                                  <p>Dibuat pada</p>
                                                </div>
                                                <div class="form-group col-lg-0">
                                                  <p>:</p>
                                                </div>
                                                <div class="form-group col-lg-8">
                                                  <span>{{ $pembelian->created_at }}</span>
                                                </div>
                                              </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Terakhir diubah</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>{{ $pembelian->updated_at }}</span>
                                              </div>
                                            </div>
                                          </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Tutup') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <a style="width: 80px" href="{{ route('pembelian.show', $pembelian->id) }}" target="_blank" class="btn btn-primary btn-sm"><i
                            class="fas fa-print"></i> {{ __('Cetak') }}</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  
@endsection

@section('scripts')

@endsection