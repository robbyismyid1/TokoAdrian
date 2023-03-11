@extends('layouts.main', ['activePage' => 'pemasok', 'titlePage' => __('Pemasok')])
@section('title')
    {{ __('Pemasok | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-primary py-3">
        <form action="{{ route('pemasok.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Data Pemasok') }}
            @if (auth()->user()->hasPermission('create_pemasok'))
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
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_pemasok" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">{{ __('No.') }}</th>
                <th>{{ __('Nama Pemasok') }}</th>
                <th>{{ __('Telepon') }}</th>
                <th>{{ __('Alamat') }}</th>
                <th>{{ __('Hutang') }}</th>
                <th width="15%">{{ __('Detail Pembelian') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($pemasoks as $index => $pemasok)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pemasok->nama_pemasok }}</td>
                    <td>{{ $pemasok->telepon }}</td>
                    <td>{{ $pemasok->alamat }}</td>
                    <td> 
                      @if ($pemasok->pembelian->sum('due') == 0)
                          <center><span class="badge bg-success text-white">Rp{{ number_format($pemasok->pembelian->sum('due'), 2, ',', '.') }}.</span></center>
                      @else
                          <center><span class="badge bg-danger text-white">Rp{{ number_format($pemasok->pembelian->sum('due'), 2, ',', '.') }}.</span></center>
                      @endif
                  </td>
                  <td>
                    <center>
                    @if ($pemasok->pembelian->count() > 0)
                      <a class="btn btn-primary btn-sm"
                          href="{{ route('pemasok.detail', $pemasok->id) }}">Detail dari
                          {{ $pemasok->pembelian->count() }} pembelian</i></a>
                      @else
                      <a class="btn btn-primary btn-sm disabled"
                          href="{{ route('pemasok.edit', $pemasok->id) }}">Detail dari
                          {{ $pemasok->pembelian->count() }} pembelian</i></a>
                    @endif
                    </center>
                  </td>
                    <td>
                        <a style="width: 80px" type="" class="btn btn-info btn-sm text-white"
                            data-toggle="modal" data-target="#showModal{{ $pemasok->id }}">
                                <i class="fas fa-eye"></i> {{ __('Detail') }}</a>
                                <div class="modal fade bd-example-modal-lg" id="showModal{{ $pemasok->id }}" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-info py-3">
                                            <span class="m-0 font-weight-bold text-white">Detail {{ $pemasok->nama_pemasok }}</span>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Nama</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>{{ $pemasok->nama_pemasok }}</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Status Saya</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                @if ($pemasok->pembelian->sum('due') == 0)
                                                  <span class="badge bg-success text-white"> {{ __('TIDAK PUNYA HUTANG') }}</span>
                                                @else
                                                  <span class="badge bg-danger text-white"> {{ __('MASIH PUNYA HUTANG') }}</span>
                                                @endif
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Hutang Saya</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                @if ($pemasok->pembelian->sum('due') == 0)
                                                  <span class="badge bg-success text-white">Rp{{ number_format($pemasok->pembelian->sum('due'), 2, ',', '.') }}.</span>
                                                @else
                                                  <span class="badge bg-danger text-white">Rp{{ number_format($pemasok->pembelian->sum('due'), 2, ',', '.') }}.</span>
                                                @endif
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Telepon</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>{{ $pemasok->telepon }}</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Alamat</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>{{ $pemasok->alamat }}</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Deskripsi</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>{{ $pemasok->deskripsi }}</span>
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
                                                <span>{{ $pemasok->created_at }}</span>
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
                                                <span>{{ $pemasok->updated_at }}</span>
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
                        @if (auth()->user()->hasPermission('update_pemasok'))
                        <a style="width: 80px" class="btn btn-warning btn-sm"
                            href="{{ route('pemasok.edit', $pemasok->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @else
                        <a style="width: 80px" class="btn btn-warning btn-sm disabled"
                            href="{{ route('pemasok.edit', $pemasok->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_pemasok'))
                        <button style="width: 80px" id="delete" onclick="deletemoderator({{ $pemasok->id }})"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                            {{ __('Hapus') }}</button>
                        <form id="form-delete-{{ $pemasok->id }}"
                            action="{{ route('pemasok.destroy', $pemasok->id) }}" method="post"
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
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header bg-success py-3">
            <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Pemasok') }}</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form-create" method="POST" action="{{ route('pemasok.store') }}">
              @csrf
              <div class="form-row">
                <div class="form-group col-lg-12">
                    <label for="">{{ __('Nama Pemasok') }}</label>
                    <input class="form-control{{ $errors->has('nama_pemasok') ? ' is-invalid' : '' }}" name="nama_pemasok" type="text" placeholder="{{ __('') }}" value="{{ old('nama_pemasok') }}" required="true" aria-required="true"/>
                    @if ($errors->has('nama_pemasok'))
                        <small class="text-danger">{{ $errors->first('nama_pemasok') }}</small>
                    @endif
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-lg-12">
                    <label for="">{{ __('Telepon') }}</label>
                    <input class="form-control{{ $errors->has('telepon') ? ' is-invalid' : '' }}" name="telepon" type="text" placeholder="{{ __('') }}" value="{{ old('telepon') }}" required="true" aria-required="true"/>
                    @if ($errors->has('telepon'))
                        <small class="text-danger">{{ $errors->first('telepon') }}</small>
                    @endif
                </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-lg-12">
                      <label for="">{{ __('Alamat') }}</label>
                      <textarea type="text" name="alamat" id="" class="form-control" value="{{ old('alamat') }}">{{ old('alamat') }}</textarea>
                      @if ($errors->has('alamat'))
                          <small class="text-danger">{{ $errors->first('alamat') }}</small>
                      @endif
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-lg-12">
                      <label for="">{{ __('Deskripsi') }}</label>
                      <textarea type="text" name="deskripsi" id="" class="form-control" value="{{ old('deskripsi') }}">{{ old('deskripsi') }}</textarea>
                      @if ($errors->has('deskripsi'))
                          <small class="text-danger">{{ $errors->first('deskripsi') }}</small>
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
              result.dismiss === Swal.DismissReason.cancel
          ) {
              Swal.fire(
                  'Dibatalkan',
                  'Data Pemasok Kamu Aman! :)',
                  'success'
              )
          }
      });
  }

</script>
@endsection