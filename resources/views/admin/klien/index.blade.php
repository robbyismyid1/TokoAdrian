@extends('layouts.main', ['activePage' => 'klien', 'titlePage' => __('Klien')])
@section('title')
    {{ __('Klien | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-primary py-3">
        <form action="{{ route('klien.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Data Klien') }}
            @if (auth()->user()->hasPermission('create_klien'))
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
          <table class="table table-bordered" id="tabel_klien" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">{{ __('No.') }}</th>
                <th>{{ __('Nama Klien') }}</th>
                <th>{{ __('NIK') }}</th>
                <th>{{ __('Telepon') }}</th>
                <th>{{ __('Hutang') }}</th>
                <th width="15%">{{ __('Detail Penjualan') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($kliens as $index => $klien)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $klien->nama_klien }}</td>
                    <td>{{ $klien->nik }}</td>
                    <td>{{ $klien->telepon}}</td>
                    <td>
                        
                        @if ($klien->penjualan->sum('due') == 0)
                            <center><span class="badge bg-success text-white">Rp{{ number_format($klien->penjualan->sum('due'), 2, ',', '.') }}.</span></center>
                        @else
                            <center><span class="badge bg-danger text-white">Rp{{ number_format($klien->penjualan->sum('due'), 2, ',', '.') }}.</span></center>
                        @endif
                    </td>
                    <td>
                      @if ($klien->penjualan->count() > 0)
                        <a class="btn btn-primary btn-sm"
                            href="{{ route('klien.detail', $klien->id) }}">Detail dari
                            {{ $klien->penjualan->count() }} penjualan</i></a>
                        @else
                        <a class="btn btn-primary btn-sm disabled"
                            href="{{ route('klien.edit', $klien->id) }}">Detail dari
                            {{ $klien->penjualan->count() }} penjualan</i></a>
                      @endif
                    </td>
                    <td>
                        <a style="width: 80px" type="" class="btn btn-info btn-sm text-white"
                            data-toggle="modal" data-target="#showModal{{ $klien->id }}">
                                <i class="fas fa-eye"></i> {{ __('Detail') }}</a>
                                <div class="modal fade bd-example-modal-lg" id="showModal{{ $klien->id }}" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-info py-3">
                                            <span class="m-0 font-weight-bold text-white">Detail {{ $klien->nama_klien }}</span>
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
                                                <span>{{ $klien->nama_klien }}</span>
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
                                                @if ($klien->penjualan->sum('due') == 0)
                                                  <span class="badge bg-success text-white"> {{ __('TIDAK PUNYA HUTANG') }}</span>
                                                @else
                                                  <span class="badge bg-danger text-white"> {{ __('MASIH PUNYA HUTANG') }}</span>
                                                @endif
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
                                                @if ($klien->penjualan->sum('due') == 0)
                                                  <span class="badge bg-success text-white">Rp{{ number_format($klien->penjualan->sum('due'), 2, ',', '.') }}.</span>
                                                @else
                                                  <span class="badge bg-danger text-white">Rp{{ number_format($klien->penjualan->sum('due'), 2, ',', '.') }}.</span>
                                                @endif
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>NIK</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <span>{{ $klien->nik }}</span>
                                              </div>
                                            </div>
                                            <div class="form-row">
                                              <div class="form-group col-lg-3">
                                                <p>Foto</p>
                                              </div>
                                              <div class="form-group col-lg-0">
                                                <p>:</p>
                                              </div>
                                              <div class="form-group col-lg-8">
                                                <a href="{{ $klien->image_path }}" target="_blank">
                                                    <img src="{{ $klien->image_path }}" style="width:100%;"
                                                class="img-thumbnail" alt="">
                                                </a>
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
                                                <span>{{ $klien->telepon }}</span>
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
                                                <span>{{ $klien->alamat }}</span>
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
                                                <span>{{ $klien->deskripsi }}</span>
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
                                                <span>{{ $klien->created_at }}</span>
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
                                                <span>{{ $klien->updated_at }}</span>
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
                        @if (auth()->user()->hasPermission('update_klien'))
                        <a style="width: 80px" class="btn btn-warning btn-sm"
                            href="{{ route('klien.edit', $klien->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @else
                        <a style="width: 80px" class="btn btn-warning btn-sm disabled"
                            href="{{ route('klien.edit', $klien->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_klien'))
                        <button style="width: 80px" id="delete" onclick="deletemoderator({{ $klien->id }})"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                            {{ __('Hapus') }}</button>
                        <form id="form-delete-{{ $klien->id }}"
                            action="{{ route('klien.destroy', $klien->id) }}" method="post"
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
  <div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header bg-success py-3">
            <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Klien') }}</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form-create" method="POST" action="{{ route('klien.store') }}" enctype="multipart/form-data">
              @csrf
            <div class="form-row">
                <div class="form-group col-lg-6">
                    <label for="">{{ __('Nama Klien') }}</label>
                    <input class="form-control{{ $errors->has('nama_klien') ? ' is-invalid' : '' }}" name="nama_klien" type="text" placeholder="{{ __('') }}" value="{{ old('nama_klien') }}" required="true" aria-required="true"/>
                    @if ($errors->has('nama_klien'))
                        <small class="text-danger">{{ $errors->first('nama_klien') }}</small>
                    @endif
                </div>
                <div class="form-group col-lg-6">
                    <label for="">{{ __('Nomor Induk Kependudukan') }}</label>
                    <input class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik" type="number" placeholder="{{ __('') }}" value="{{ old('nik') }}" required="true" aria-required="true"/>
                    @if ($errors->has('nik'))
                        <small class="text-danger">{{ $errors->first('nik') }}</small>
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
            <div class="form-row">
                <div class="form-group col-lg-12">
                    <label for="">{{ __('Foto') }}</label>
                    <input id="klien-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ old('image') }}" required="true" aria-required="true"/>
                    @if ($errors->has('image'))
                        <small class="text-danger">{{ $errors->first('image') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-12">
                    <img src="" style="width:150px;" 
                    class="" alt=""
                    id="klien-img-tag">
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
                  'Data Klien Kamu Aman! :)',
                  'success'
              )
          }
      });
  }

</script>

<script type="text/javascript">
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function (e) {
              $('#klien-img-tag').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
  $("#klien-img").change(function(){
      readURL(this);
  });
</script>
@endsection