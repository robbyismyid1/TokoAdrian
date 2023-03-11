@extends('layouts.main', ['activePage' => 'klien-edit', 'titlePage' => __('Ubah Klien')])
@section('title')
    {{ __('Ubah - Klien | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-warning py-3">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Mengubah Data Klien') }}
            <a href="{{ route('klien.index') }}" class="btn btn-sm btn-warning float-right" style="">
                <i class="fas fa-arrow-left"></i> </a>
        </h5>
      </div>

      <div class="card-body">
        <form action="{{ route('klien.update', $klien->id) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            @include('partials._errors')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="">{{ __('Nama Klien') }}</label>
                            <input class="form-control{{ $errors->has('nama_klien') ? ' is-invalid' : '' }}" name="nama_klien" type="text" placeholder="{{ __('') }}" value="{{ $klien -> nama_klien }}" required="true" aria-required="true"/>
                            @if ($errors->has('nama_klien'))
                                <small class="text-danger">{{ $errors->first('nama_klien') }}</small>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">{{ __('Nomor Induk Kependudukan') }}</label>
                            <input class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik" type="number" placeholder="{{ __('') }}" value="{{ $klien -> nik }}" required="true" aria-required="true"/>
                            @if ($errors->has('nik'))
                                <small class="text-danger">{{ $errors->first('nik') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="">{{ __('Telepon') }}</label>
                            <input class="form-control{{ $errors->has('telepon') ? ' is-invalid' : '' }}" name="telepon" type="text" placeholder="{{ __('') }}" value="{{ $klien -> telepon }}" required="true" aria-required="true"/>
                            @if ($errors->has('telepon'))
                                <small class="text-danger">{{ $errors->first('telepon') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="">{{ __('Alamat') }}</label>
                            <textarea type="text" name="alamat" id="" class="form-control" value="{{ old('alamat') }}">{{ $klien -> alamat }}</textarea>
                            @if ($errors->has('alamat'))
                                <small class="text-danger">{{ $errors->first('alamat') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="">{{ __('Deskripsi') }}</label>
                            <textarea type="text" name="deskripsi" id="" class="form-control" value="{{ old('deskripsi') }}">{{ $klien -> deskripsi }}</textarea>
                            @if ($errors->has('deskripsi'))
                                <small class="text-danger">{{ $errors->first('deskripsi') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12 image-preview" id="image-preview">
                            <label for="">{{ __('Foto') }}</label>
                            <input id="klien-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ $klien->image_path }}" />
                        </div>
                        <div class="form-group col-lg-12">
                            <img id="klien-img-tag" src="{{ $klien->image_path }}" style="width:35%;"
                                class="img-circle img-thumbnail img-preview">
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