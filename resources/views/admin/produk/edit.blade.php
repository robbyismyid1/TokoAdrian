@extends('layouts.main', ['activePage' => 'produk-edit', 'titlePage' => __('Ubah Produk')])
@section('title')
    {{ __('Ubah - Produk | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header bg-warning py-3">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Mengubah Data Produk') }}
            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-warning float-right" style="">
                <i class="fas fa-arrow-left"></i> </a>
        </h5>
      </div>

      <div class="card-body">
        <form action="{{ route('produk.update', $produk->id) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            @include('partials._errors')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                          <label for="">{{ __('Kode Produk') }}</label>
                          <input readonly class="form-control{{ $errors->has('kode_produk') ? ' is-invalid' : '' }}" name="kode_produk" type="text" placeholder="{{ __('') }}" value="{{ $produk->kode_produk }}" required="true" aria-required="true"/>
                          @if ($errors->has('kode_produk'))
                            <small class="text-danger">{{ $errors->first('kode_produk') }}</small>
                          @endif
                        </div>
                        <div class="form-group col-lg-6">
                          <label for="">{{ __('Kategori') }}</label>
                          <select name="kategori_id" class="form-control">
                            <option value="">{{ __('-- Pilih Kategori --') }}</option>
                                @foreach ($kategori as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ $produk->kategori_id == $kategori->id ? 'selected' : ''}}>{{
                                    $kategori->kode_kategori }} {{
                                    $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-lg-12">
                          <label for="">{{ __('Nama Produk') }}</label>
                          <input class="form-control{{ $errors->has('nama_produk') ? ' is-invalid' : '' }}" name="nama_produk" type="text" placeholder="{{ __('') }}" value="{{ $produk->nama_produk }}" required="true" aria-required="true"/>
                          @if ($errors->has('nama_produk'))
                            <small class="text-danger">{{ $errors->first('nama_produk') }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-lg-12">
                          <label for="">{{ __('Deskripsi') }}</label>
                          <textarea type="text" name="deskripsi" id="" class="form-control" value="{{ old('deskripsi') }}" required="true" aria-required="true">{{ $produk->deskripsi }}</textarea>
                          @if ($errors->has('deskripsi'))
                            <small class="text-danger">{{ $errors->first('deskripsi') }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-lg-6">
                          <label for="">{{ __('Harga Pembelian') }}</label>
                          <input class="form-control{{ $errors->has('harga_pembelian') ? ' is-invalid' : '' }}" name="harga_pembelian" type="number" placeholder="{{ __('') }}" value="{{ $produk->harga_pembelian }}" required="true" aria-required="true"/>
                          @if ($errors->has('harga_pembelian'))
                            <small class="text-danger">{{ $errors->first('harga_pembelian') }}</small>
                          @endif
                        </div>
                        <div class="form-group col-lg-6">
                          <label for="">{{ __('Harga Penjualan') }}</label>
                          <input class="form-control{{ $errors->has('harga_penjualan') ? ' is-invalid' : '' }}" name="harga_penjualan" type="number" placeholder="{{ __('') }}" value="{{ $produk->harga_penjualan }}" required="true" aria-required="true"/>
                          @if ($errors->has('harga_penjualan'))
                            <small class="text-danger">{{ $errors->first('harga_penjualan') }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-lg-6">
                          <label for="">{{ __('Stok') }}</label>
                          <input class="form-control{{ $errors->has('stok') ? ' is-invalid' : '' }}" name="stok" type="number" placeholder="{{ __('') }}" value="{{ $produk->stok }}" required="true" aria-required="true"/>
                          @if ($errors->has('stok'))
                            <small class="text-danger">{{ $errors->first('stok') }}</small>
                          @endif
                        </div>
                        <div class="form-group col-lg-6">
                          <label for="">{{ __('Minimal Stok') }}</label>
                          <input class="form-control{{ $errors->has('minstok') ? ' is-invalid' : '' }}" name="minstok" type="number" placeholder="{{ __('') }}" value="{{ $produk->minstok }}" required="true" aria-required="true"/>
                          @if ($errors->has('minstok'))
                            <small class="text-danger">{{ $errors->first('minstok') }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-lg-12 image-preview" id="image-preview">
                            <label for="">{{ __('Foto') }}</label>
                            <input id="profile-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ $produk->image_path }}" />
                        </div>
                        <div class="form-group col-lg-12">
                            <img id="profile-img-tag" src="{{ $produk->image_path }}" style="width:200px;"
                                class="img-thumbnail img-preview">
                        </div>
                          @if ($errors->has('image'))
                            <small class="text-danger">{{ $errors->first('image') }}</small>
                          @endif
                        </div>
                    </div>
        </div>
            <div class="modal-footer form-group">
                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> {{ __('Ubah') }}</button>
            </div>
        </form>
      </div>
    </div>

  </div>
  
@endsection

@section('scripts')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-img").change(function(){
        readURL(this);
    });
  </script>
@endsection