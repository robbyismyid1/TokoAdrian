@extends('layouts.main', ['activePage' => 'kategori', 'titlePage' => __('Kategori')])
@section('title')
    {{ __('Kategori | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-primary py-3">
        <form action="{{ route('kategori.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Data Kategori') }}
            @if (auth()->user()->hasPermission('create_kategori'))
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
          <table class="table table-bordered" id="tabel_kategori" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">{{ __('No.') }}</th>
                <th>{{ __('Kode Kategori') }}</th>
                <th>{{ __('Nama Kategori') }}</th>
                <th width="20%">{{ __('Produk Terkait') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($kategoris as $index => $kategori)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kategori -> kode_kategori }}</td>
                    <td>{{ $kategori -> nama_kategori }}</td>
                    <td>
                      @if (auth()->user()->hasPermission('read_produk'))
                        <center>
                        @if ($kategori->produk->count() != 0)
                          <a href="{{ route('produk.index', ['kategori_id'=>$kategori->id]) }}"
                            class="btn btn-primary text-white"><i class="fas fa-link"></i>
                            {{
                            $kategori ->
                            produk->count() }} Produk Terkait</a>
                        @else
                          <a href="{{ route('produk.index', ['kategori_id'=>$kategori->id]) }}"
                            class="btn btn-primary text-white disabled"><i class="fas fa-link"></i>
                            {{
                            $kategori ->
                            produk->count() }} Produk Terkait</a>
                        @endif
                        </center>
                      @else
                        <center>
                        @if ($kategori->produk->count() != 0)
                          <a href="{{ route('produk.index', ['kategori_id'=>$kategori->id]) }}"
                            class="btn btn-primary text-white disabled"><i class="fas fa-link"></i>
                            {{
                            $kategori ->
                            produk->count() }} Produk Terkait</a>
                        @else
                          <a href="{{ route('produk.index', ['kategori_id'=>$kategori->id]) }}"
                            class="btn btn-primary text-white disabled"><i class="fas fa-link"></i>
                            {{
                            $kategori ->
                            produk->count() }} Produk Terkait</a>
                        @endif
                        </center>
                      @endif
                    </td>
                    <td>
                        @if (auth()->user()->hasPermission('update_kategori'))
                        <a style="width: 80px" class="btn btn-warning btn-sm"
                            href="{{ route('kategori.edit', $kategori->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @else
                        <a style="width: 80px" class="btn btn-warning btn-sm disabled"
                            href="{{ route('kategori.edit', $kategori->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_kategori'))
                        <button style="width: 80px" id="delete" onclick="deletemoderator({{ $kategori->id }})"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                            {{ __('Hapus') }}</button>
                        <form id="form-delete-{{ $kategori->id }}"
                            action="{{ route('kategori.destroy', $kategori->id) }}" method="post"
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
            <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Kategori') }}</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form-create" method="POST" action="{{ route('kategori.store') }}">
              @csrf
              <div class="form-group">
                <label for="">{{ __('Kode Kategori') }}</label>
                <input readonly class="form-control{{ $errors->has('kode_kategori') ? ' is-invalid' : '' }}" name="kode_kategori" id="barcode" type="text" placeholder="{{ __('') }}" value="#KTGR{{ $count+1 }}" required="true" aria-required="true"/>
                @if ($errors->has('kode_kategori'))
                  <small class="text-danger">{{ $errors->first('kode_kategori') }}</small>
                @endif
              </div>
              <div class="form-group">
                <label for="">{{ __('Nama Kategori') }}</label>
                <input class="form-control{{ $errors->has('nama_kategori') ? ' is-invalid' : '' }}" name="nama_kategori" id="nama_kategori" type="text" placeholder="{{ __('') }}" value="{{ old('nama_kategori') }}" required="true" aria-required="true"/>
                @if ($errors->has('nama_kategori'))
                  <small class="text-danger">{{ $errors->first('nama_kategori') }}</small>
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
              result.dismiss === Swal.DismissReason.cancel
          ) {
              Swal.fire(
                  'Dibatalkan',
                  'Data Kategori Kamu Aman! :)',
                  'success'
              )
          }
      });
  }

</script>
@endsection