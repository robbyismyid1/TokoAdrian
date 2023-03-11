@extends('layouts.main', ['activePage' => 'pemasok-edit', 'titlePage' => __('Ubah Pemasok')])
@section('title')
    {{ __('Ubah - Pemasok | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-warning py-3">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Mengubah Data Pemasok') }}
            <a href="{{ route('pemasok.index') }}" class="btn btn-sm btn-warning float-right" style="">
                <i class="fas fa-arrow-left"></i> </a>
        </h5>
      </div>

      <div class="card-body">
        <form action="{{ route('pemasok.update', $pemasok->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            @include('partials._errors')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="">{{ __('Nama Pemasok') }}</label>
                            <input class="form-control{{ $errors->has('nama_pemasok') ? ' is-invalid' : '' }}" name="nama_pemasok" type="text" placeholder="{{ __('') }}" value="{{ $pemasok->nama_pemasok }}" required="true" aria-required="true"/>
                            @if ($errors->has('nama_pemasok'))
                                <small class="text-danger">{{ $errors->first('nama_pemasok') }}</small>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">{{ __('Telepon') }}</label>
                            <input class="form-control{{ $errors->has('telepon') ? ' is-invalid' : '' }}" name="telepon" type="text" placeholder="{{ __('') }}" value="{{ $pemasok->telepon }}" required="true" aria-required="true"/>
                            @if ($errors->has('telepon'))
                                <small class="text-danger">{{ $errors->first('telepon') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="">{{ __('Alamat') }}</label>
                            <textarea type="text" name="alamat" id="" class="form-control" value="{{ old('alamat') }}">{{ $pemasok->alamat }}</textarea>
                            @if ($errors->has('alamat'))
                                <small class="text-danger">{{ $errors->first('alamat') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="">{{ __('Deskripsi') }}</label>
                            <textarea type="text" name="deskripsi" id="" class="form-control" value="{{ old('deskripsi') }}">{{ $pemasok->deskripsi }}</textarea>
                            @if ($errors->has('deskripsi'))
                                <small class="text-danger">{{ $errors->first('deskripsi') }}</small>
                            @endif
                        </div>
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