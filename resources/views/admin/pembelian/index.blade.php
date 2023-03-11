@extends('layouts.main', ['activePage' => 'pembelian', 'titlePage' => __('Pembelian')])
@section('title')
    {{ __('Pembelian | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header bg-primary py-3">
        <form action="{{ route('pembelian.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Data Pembelian') }}
            @if (auth()->user()->hasPermission('create_pembelian'))
            <a type="" class="btn btn-sm btn-success float-right" style=""
            href="{{ route('pembelian.create') }}"><i class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @else
            <a type="" class="btn btn-success disabled btn float-right" 
            href="{{ route('pembelian.create') }}"><i
                    class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @endif
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
                <th>{{ __('Total') }}</th>
                <th>{{ __('Diskon') }}</th>
                <th>{{ __('Jumlah Total') }}</th>
                <th>{{ __('Dibayar') }}</th>
                <th>{{ __('Hutang') }}</th>
                <th>{{ __('Status') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($pembelians as $index => $pembelian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pembelian->nomor_pembelian }}</td>
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
                    <td>
                        <button style="width: 80px" type="" class="btn btn-info btn-sm text-white"
                            data-toggle="modal" data-target="#showModal{{ $pembelian->id }}">
                                <i class="fas fa-eye"></i> {{ __('Detail') }}</button>
                                <div class="modal fade bd-example-modal-lg" id="showModal{{ $pembelian->id }}" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
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
                                                    <p>Pemasok</p>
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
                        @if (auth()->user()->hasPermission('update_pembelian'))
                            @if ($pembelian->due != 0)
                                <button style="width: 80px" class="btn btn-success btn-sm text-white" data-toggle="modal" data-target="#bayarModal{{ $pembelian->id }}"><i class="fas fa-credit-card"></i> {{ __('Bayar') }}</button>
                            @endif
                        @else
                            @if ($pembelian->due != 0)
                                <button style="width: 80px" class="btn btn-success btn-sm disabled" data-toggle="modal" data-target="#bayarModal{{ $pembelian->id }}"><i class="fas fa-credit-card"></i> {{ __('Bayar') }}</button>
                            @endif
                        @endif
                        <div class="modal fade" id="bayarModal{{ $pembelian->id }}" tabindex="-1" role="dialog" aria-labelledby="bayarModal{{ $pembelian->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header bg-success py-3">
                                    <span class="m-0 font-weight-bold text-white">{{ __('Bayar Hutang') }} {{ $pembelian->nomor_pembelian }}</span>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{ route('pembelian.hutangsaya', $pembelian->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">{{ __('Nomor Pembelian') }}</label>
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <input readonly class="form-control{{ $errors->has('nomor_pembelian') ? ' is-invalid' : '' }}" name="nomor_pembelian" type="text" placeholder="{{ __('') }}" value="{{ $pembelian->nomor_pembelian }}" required="true" aria-required="true"/>
                                                @if ($errors->has('nomor_pembelian'))
                                                    <small class="text-danger">{{ $errors->first('nomor_pembelian') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">{{ __('Total dibayar') }}</label>
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <input readonly class="form-control{{ $errors->has('dibayar') ? ' is-invalid' : '' }}" name="dibayar" type="number" placeholder="{{ __('') }}" value="{{ $pembelian->dibayar }}" required="true" aria-required="true"/>
                                                @if ($errors->has('dibayar'))
                                                    <small class="text-danger">{{ $errors->first('dibayar') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">{{ __('Hutang') }}</label>
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <input readonly class="form-control{{ $errors->has('hutang') ? ' is-invalid' : '' }}" name="hutang" type="number" placeholder="{{ __('') }}" value="{{ $pembelian->due }}" required="true" aria-required="true"/>
                                                @if ($errors->has('hutang'))
                                                    <small class="text-danger">{{ $errors->first('hutang') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">{{ __('Bayar') }}</label>
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <input class="form-control{{ $errors->has('bayar') ? ' is-invalid' : '' }}" name="bayar" type="number" placeholder="{{ __('') }}" value="{{ $pembelian->due }}" required="true" aria-required="true" min="0" max="{{ $pembelian->due }}"/>
                                                @if ($errors->has('bayar'))
                                                    <small class="text-danger">{{ $errors->first('bayar') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                  </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Tutup') }}</button>
                                            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('Tambah') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->hasPermission('update_pembelian'))
                        <a style="width: 80px" class="btn btn-warning btn-sm"
                            href="{{ route('pembelian.edit', $pembelian->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @else
                        <a style="width: 80px" class="btn btn-warning btn-sm disabled"
                            href="{{ route('pembelian.edit', $pembelian->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_pembelian'))
                        <button style="width: 80px" id="delete" onclick="deletemoderator({{ $pembelian->id }})"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                            {{ __('Hapus') }}</button>
                        <form id="form-delete-{{ $pembelian->id }}"
                            action="{{ route('pembelian.destroy', $pembelian->id) }}" method="post"
                            style="display:inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                        </form>
                        @else
                        <button style="width: 80px" type="submit" class="btn btn-danger btn-sm disabled"><i
                                class="fas fa-trash"></i> {{ __('Hapus') }}</button>
                        @endif

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
<script type="text/javascript">
  function deletemoderator(id) {
      Swal({
          title: 'Apa kamu yakin?',
          text: "Kamu tidak akan dapat mengembalikan ini!",
          type: 'error',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Tidak, Batalkan!'
      }).then((result) => {
          if (result.value) {
              event.preventDefault();
              document.getElementById('form-delete-' + id).submit();
          } else if (
              // Read more about handling dismissals
              result.dismiss === Swal.DismissReason.cancel
          ) {
              Swal.fire(
                  'Dibatalkan',
                  'Data Pembelian Kamu Aman! :)',
                  'success'
              )
          }
      });
  }

</script>
@endsection