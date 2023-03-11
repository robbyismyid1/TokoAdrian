@extends('layouts.main', ['activePage' => 'pengaturan', 'titlePage' => __('Pengaturan')])
@section('title')
    {{ __('Pengaturan | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header bg-success py-3">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Pengaturan') }}
        </h5>
      </div>

      <div class="card-body">
        @include('layouts.flash')
        <form id="update_settings" action="{{ route('pengaturan.store') }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('post') }}
                @include('partials._errors')
                <div class="row">
                    <div class="col-md-6">
                        <input id="" type="hidden" name="id" value="{{ $store_id }}">
                        <div class="form-group">
                            <label for="">{{ __('Nama Toko') }}</label>
                            <input type="text" name="nama_toko" id="" class="form-control" value="{{ $store_name }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Deskripsi Toko') }}</label>
                            <input type="text" name="deskripsi" id="" class="form-control" value="{{ $activity }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Telepon') }}</label>
                            <input type="text" name="telepon" id="" class="form-control" value="{{ $phone }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Alamat') }}</label>
                            <input type="text" name="alamat" id="" class="form-control" value="{{ $address }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Tanggal Mulai') }}</label>
                            <input type="date" name="tanggal_mulai" class="form-control datepicker"
                                data-provide="datepicker" value="{{ $start_day }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Logo') }}</label>
                            <input id="logo-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ $logo }}"/>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <img id="logo-img-tag" src="{{ asset('/uploads/settings/'.$logo) }}" style="width:200px;"
                                class="img-preview">
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">{{ __('Perbarui Pengaturan') }}</button>
                    </div>
                </div>
                    
            </form>
        </div>
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
                $('#logo-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#logo-img").change(function(){
        readURL(this);
    });
</script>
@endsection