@extends('layouts.main', ['activePage' => 'produk', 'titlePage' => __('Produk')])
@section('title')
    {{ __('Produk | TOKO ADRIAN') }}
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
        <form action="{{ route('produk.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">
            @if (auth()->user()->hasPermission('create_produk'))
            <a type="" class="btn btn-sm btn-success float-right" style=""
            data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @else
            <a type="" class="btn btn-success disabled btn float-right" 
            data-toggle="modal" data-target="#createModal"><i
                    class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @endif
        </h5>
        <div class="row">
          <div class="col-md-4 form-group">
              <input type="text" name="search" class="form-control" placeholder="Cari Produk"
                  value="{{ request()->search }}">
          </div>
          <div class="col-md-4 form-group">
            <select name="kategori_id" class="form-control">
              <option value="">{{ __('-- Pilih Kategori --') }}</option>
              @foreach ($kategori as $kategori)
              <option value="{{ $kategori->id }}"
                  {{ request()->kategori_id == $kategori->id ? 'selected' : ''}}>{{
                  $kategori->kode_kategori }} - {{
                  $kategori->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 form-group">
              <button type="submit" class="btn btn-success float-left"><i class="fas fa-search"></i> Cari</button>
          </div>
      </div>
        </form>
      </div>

      <div class="card-body">
        
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_produk" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">{{ __('No.') }}</th>
                <th>{{ __('Kode Produk') }}</th>
                <th>{{ __('Nama Produk') }}</th>
                <th>{{ __('Deskripsi') }}</th>
                <th>{{ __('Harga Pembelian') }}</th>
                <th>{{ __('Harga Penjualan') }}</th>
                <th>{{ __('Stok') }}</th>
                <th>{{ __('Foto') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($produks as $index => $produk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $produk->kode_produk }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->deskripsi }}</td>
                    <td>Rp{{ number_format($produk->harga_pembelian, 2, ',', '.') }}.</td>
                    <td>Rp{{ number_format($produk->harga_penjualan, 2, ',', '.') }}.</td>
                    <td>{{ number_format($produk->stok, 0, '', '.') }}</td>
                    <td>
                      <a style="width: 80px" data-toggle="modal" data-target="#imageModal{{ $produk->id }}">
                        <img src="{{ $produk->image_path }}" style="width:50px;"
                        class="img-circle img-thumbnail" alt="">
                      </a>
                        <div class="modal fade bd-example-modal-lg" id="imageModal{{ $produk->id }}" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info py-3">
                                  <span class="m-0 font-weight-bold text-white">Foto {{ $produk->nama_produk }}</span>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <center><img src="{{ asset('uploads') }}/product_images/{{ $produk->image }}" style="width:35%;" alt=""></center>
                                </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Tutup') }}</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                    </td>    
                    <td>
                    </div>
                        @if (auth()->user()->hasPermission('update_produk'))
                        <a style="width: 80px" class="btn btn-warning btn-sm"
                            href="{{ route('produk.edit', $produk->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @else
                        <a style="width: 80px" class="btn btn-warning btn-sm disabled"
                            href="{{ route('produk.edit', $produk->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_produk'))
                        <button style="width: 80px" id="delete" onclick="deletemoderator({{ $produk->id }})"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                            {{ __('Hapus') }}</button>
                        <form id="form-delete-{{ $produk->id }}"
                            action="{{ route('produk.destroy', $produk->id) }}" method="post"
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
            <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Produk') }}</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form-create" method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
              @csrf
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="">{{ __('Kode Produk') }}</label>
                <input readonly class="form-control{{ $errors->has('kode_produk') ? ' is-invalid' : '' }}" name="kode_produk" type="text" placeholder="{{ __('') }}" value="#PRDK{{ $count+1 }}" required="true" aria-required="true"/>
                @if ($errors->has('kode_produk'))
                  <small class="text-danger">{{ $errors->first('kode_produk') }}</small>
                @endif
              </div>
              <div class="form-group col-lg-6">
                <label for="">{{ __('Kategori') }}</label>
                <select name="kategori_id" class="form-control">
                  <option value="">{{ __('-- Pilih Kategori --') }}</option>
                  @foreach ($kategoris as $kategori)
                  <option value="{{ $kategori->id }}"
                      {{ old('kategori_id') == $kategori->id ? 'selected' : ''}}>{{
                      $kategori->kode_kategori }} - {{
                      $kategori->nama_kategori }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-12">
                <label for="">{{ __('Nama Produk') }}</label>
                <input class="form-control{{ $errors->has('nama_produk') ? ' is-invalid' : '' }}" name="nama_produk" type="text" placeholder="{{ __('') }}" value="{{ old('nama_produk') }}" required="true" aria-required="true"/>
                @if ($errors->has('nama_produk'))
                  <small class="text-danger">{{ $errors->first('nama_produk') }}</small>
                @endif
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-12">
                <label for="">{{ __('Deskripsi') }}</label>
                <textarea type="text" name="deskripsi" id="" class="form-control" value="{{ old('deskripsi') }}"></textarea>
                @if ($errors->has('deskripsi'))
                  <small class="text-danger">{{ $errors->first('deskripsi') }}</small>
                @endif
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="">{{ __('Harga Pembelian') }}</label>
                <input class="form-control{{ $errors->has('harga_pembelian') ? ' is-invalid' : '' }}" name="harga_pembelian" type="number" placeholder="{{ __('') }}" value="{{ old('harga_pembelian') }}" required="true" aria-required="true"/>
                @if ($errors->has('harga_pembelian'))
                  <small class="text-danger">{{ $errors->first('harga_pembelian') }}</small>
                @endif
              </div>
              <div class="form-group col-lg-6">
                <label for="">{{ __('Harga Penjualan') }}</label>
                <input class="form-control{{ $errors->has('harga_penjualan') ? ' is-invalid' : '' }}" name="harga_penjualan" type="number" placeholder="{{ __('') }}" value="{{ old('harga_penjualan') }}" required="true" aria-required="true"/>
                @if ($errors->has('harga_penjualan'))
                  <small class="text-danger">{{ $errors->first('harga_penjualan') }}</small>
                @endif
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="">{{ __('Stok') }}</label>
                <input class="form-control{{ $errors->has('stok') ? ' is-invalid' : '' }}" name="stok" type="number" placeholder="{{ __('') }}" value="{{ old('stok') }}" required="true" aria-required="true"/>
                @if ($errors->has('stok'))
                  <small class="text-danger">{{ $errors->first('stok') }}</small>
                @endif
              </div>
              <div class="form-group col-lg-6">
                <label for="">{{ __('Minimal Stok') }}</label>
                <input class="form-control{{ $errors->has('minstok') ? ' is-invalid' : '' }}" name="minstok" type="number" placeholder="{{ __('') }}" value="1" required="true" aria-required="true"/>
                @if ($errors->has('minstok'))
                  <small class="text-danger">{{ $errors->first('minstok') }}</small>
                @endif
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-12">
                <label for="">{{ __('Foto') }}</label>
                <input id="produk-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ old('image') }}"/>
                @if ($errors->has('image'))
                  <small class="text-danger">{{ $errors->first('image') }}</small>
                @endif
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-12">
                <img src="" style="width: 150px;" 
                class="" alt=""
                id="produk-img-tag">
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
              // Read more about handling dismissals
              result.dismiss === Swal.DismissReason.cancel
          ) {
              Swal.fire(
                  'Dibatalkan',
                  'Data Produk Kamu Aman! :)',
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
              $('#produk-img-tag').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
  $("#produk-img").change(function(){
      readURL(this);
  });
</script>
@endsection