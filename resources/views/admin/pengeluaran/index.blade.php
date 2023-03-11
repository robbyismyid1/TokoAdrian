@extends('layouts.main', ['activePage' => 'pengeluaran', 'titlePage' => __('Pengeluaran')])
@section('title')
    {{ __('Pengeluaran | TOKO ADRIAN') }}
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
        <form action="{{ route('pengeluaran.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Data Pengeluaran') }}
            @if (auth()->user()->hasPermission('create_pengeluaran'))
            <a type="" class="btn btn-sm btn-success float-right" style=""
            data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @else
            <a type="" class="btn btn-success disabled btn float-right" 
            data-toggle="modal" data-target="#createModal"><i
                    class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @endif
        </h5>
        </form>
      </div>

      <div class="card-body">
        @include('layouts.flash')
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_pengeluaran" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">{{ __('No.') }}</th>
                <th>{{ __('Nama Pengeluaran') }}</th>
                <th>{{ __('Deskripsi') }}</th>
                <th>{{ __('Biaya') }}</th>
                <th>{{ __('Keterangan Waktu') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($pengeluarans as $index => $pengeluaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pengeluaran->nama_pengeluaran }}</td>
                    <td>{{ $pengeluaran->deskripsi_pengeluaran }}</td>
                    <td>
                        <span class="badge bg-danger text-white">Rp{{ number_format($pengeluaran->harga_pengeluaran, 2, ',', '.') }}.</span>
                    </td>
                    <td>{{ $pengeluaran->created_at->format('l. j, F, Y / H:i:s') }}</td>
                    <td>
                        @if (auth()->user()->hasPermission('update_pengeluaran'))
                        <a style="width: 80px" class="btn btn-warning btn-sm"
                            href="" data-toggle="modal" data-target="#editModal{{ $pengeluaran->id }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                                <div class="modal fade" id="editModal{{ $pengeluaran->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $pengeluaran->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-success py-3">
                                            <span class="m-0 font-weight-bold text-white">{{ __('Edit Data Pengeluaran') }}</span>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <form id="form-create" method="POST" action="{{ route('pengeluaran.update', $pengeluaran->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="">{{ __('Nama Pengeluaran') }}</label>
                                                <input class="form-control{{ $errors->has('nama_pengeluaran') ? ' is-invalid' : '' }}" name="nama_pengeluaran" id="nama_pengeluaran" type="text" placeholder="{{ __('') }}" value="{{ $pengeluaran->nama_pengeluaran }}" required="true" aria-required="true"/>
                                                @if ($errors->has('nama_pengeluaran'))
                                                  <small class="text-danger">{{ $errors->first('nama_pengeluaran') }}</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('Deskripsi Pengeluaran') }}</label>
                                                <textarea class="form-control{{ $errors->has('deskripsi_pengeluaran') ? ' is-invalid' : '' }}" name="deskripsi_pengeluaran" id="" cols="30" rows="10" required="true" aria-required="true">{{ $pengeluaran->deskripsi_pengeluaran }}</textarea>
                                                @if ($errors->has('deskripsi_pengeluaran'))
                                                  <small class="text-danger">{{ $errors->first('deskripsi_pengeluaran') }}</small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('Biaya Pengeluaran') }}</label>
                                                <input class="form-control{{ $errors->has('harga_pengeluaran') ? ' is-invalid' : '' }}" name="harga_pengeluaran" id="harga_pengeluaran" type="number" placeholder="{{ __('') }}" value="{{ $pengeluaran->harga_pengeluaran }}" required="true" aria-required="true"/>
                                                @if ($errors->has('harga_pengeluaran'))
                                                  <small class="text-danger">{{ $errors->first('harga_pengeluaran') }}</small>
                                                @endif
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
                        @else
                        <a style="width: 80px" class="btn btn-warning btn-sm disabled"
                            href="{{ route('pengeluaran.edit', $pengeluaran->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_pengeluaran'))
                        <button style="width: 80px" id="delete" onclick="deletemoderator({{ $pengeluaran->id }})"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                            {{ __('Hapus') }}</button>
                        <form id="form-delete-{{ $pengeluaran->id }}"
                            action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="post"
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
    <style>
        
    </style>
    <div class="card shadow mb-4">
        <div class="card-header bg-success py-3">
            <div class="form-row">
                <h5 class="m-0 font-weight-bold text-white">{{ __('Total Pengeluaran') }}</h5>
                <div class="ml-auto">
                    <input type="text" readonly class="form-control text-center" value="Rp{{ number_format($totalpengeluaran, 2, ',', '.') }}.">
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header bg-success py-3">
            <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Pengeluaran') }}</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form-create" method="POST" action="{{ route('pengeluaran.store') }}">
              @csrf
            <div class="form-group">
                <label for="">{{ __('Nama Pengeluaran') }}</label>
                <input class="form-control{{ $errors->has('nama_pengeluaran') ? ' is-invalid' : '' }}" name="nama_pengeluaran" id="nama_pengeluaran" type="text" placeholder="{{ __('') }}" value="{{ old('nama_pengeluaran') }}" required="true" aria-required="true"/>
                @if ($errors->has('nama_pengeluaran'))
                  <small class="text-danger">{{ $errors->first('nama_pengeluaran') }}</small>
                @endif
            </div>
            <div class="form-group">
                <label for="">{{ __('Deskripsi Pengeluaran') }}</label>
                <textarea class="form-control{{ $errors->has('deskripsi_pengeluaran') ? ' is-invalid' : '' }}" name="deskripsi_pengeluaran" id="" cols="30" rows="10" required="true" aria-required="true">{{ old('deksripsi_pegeluaran') }}</textarea>
                @if ($errors->has('deskripsi_pengeluaran'))
                  <small class="text-danger">{{ $errors->first('deskripsi_pengeluaran') }}</small>
                @endif
            </div>
            <div class="form-group">
                <label for="">{{ __('Biaya Pengeluaran') }}</label>
                <input class="form-control{{ $errors->has('harga_pengeluaran') ? ' is-invalid' : '' }}" name="harga_pengeluaran" id="harga_pengeluaran" type="number" placeholder="{{ __('') }}" value="{{ old('harga_pengeluaran') }}" required="true" aria-required="true"/>
                @if ($errors->has('harga_pengeluaran'))
                  <small class="text-danger">{{ $errors->first('harga_pengeluaran') }}</small>
                @endif
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
                  'Data Pengeluaran Kamu Aman! :)',
                  'success'
              )
          }
      });
  }

</script>
@endsection