@extends('layouts.main', ['activePage' => 'kategori-edit', 'titlePage' => __('Ubah Kategori')])
@section('title')
    {{ __('Ubah - Kategori | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">
    
    <div class="card shadow mb-4">
      <div class="card-header bg-warning py-3">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Mengubah Data Kategori') }}
            <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-warning float-right" style="">
                <i class="fas fa-arrow-left"></i> </a>
        </h5>
      </div>

      <div class="card-body">
        <form action="{{ route('kategori.update', $kategori->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            @include('partials._errors')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('Kode Kategori') }}</label>
                        <input readonly type="text" name="kode_kategori" id="" class="form-control"
                            value="{{ $kategori->kode_kategori }}">
                            @if ($errors->has('kode_produk'))
                                <small class="text-danger">{{ $errors->first('kode_produk') }}</small>
                            @endif
                    </div>
                    <div class="form-group">
                        <label>{{ __('Nama Kategori') }}</label>
                        <input type="text" name="nama_kategori" id="" class="form-control"
                            value="{{ $kategori->nama_kategori }}">
                            @if ($errors->has('nama_kategori'))
                                <small class="text-danger">{{ $errors->first('nama_kategori') }}</small>
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

@endsection