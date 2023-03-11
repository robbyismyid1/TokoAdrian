@extends('layouts.main', ['activePage' => 'karyawan-edit', 'titlePage' => __('Ubah Karyawan')])
@section('title')
    {{ __('Ubah Karyawan | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header bg-warning py-3">
            <h5 class="m-0 font-weight-bold text-white">{{ __('Ubah Karyawan') }}
                <a href="{{ route('karyawan.index') }}" class="btn btn-sm btn-warning float-right" style="">
                    <i class="fas fa-arrow-left"></i> </a></h5>
        </div>

        <div class="card-body">

            <form action="{{ route('karyawan.update', $karyawan->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('put') }}
                @include('partials._errors')
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('Nama') }}</label>
                            <input type="text" name="name" id="" class="form-control"
                            value="{{ $karyawan->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Nama Pengguna') }}</label>
                            <input type="text" name="username" id="" class="form-control"
                            value="{{ $karyawan->username }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="email" id="" class="form-control" 
                            value="{{ $karyawan->email }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Foto') }}</label>
                            <input id="foto-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ $karyawan->image_path }}"/>
                        </div>
                        <div class="form-group">
                            <img id="foto-img-tag" src="{{ $karyawan->image_path }}" style="width:200px;"
                                class="img-circle img-preview">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="card shadow mb-4">
                                <div class="card-header bg-danger d-flex p-0">
                                    <h4 class="card-title p-3 white">{{ __('Hak Akses Karyawan') }}</h4>
                                    @php
                                    $models =
                                    ['kategori','produk','penjualan','pembelian','pemasok','klien','pengeluaran','kotakuang','users','pengaturan'];
                                    $maps = ['create', 'read', 'update', 'delete'];
                                    @endphp
                                    <ul class="nav nav-pills ml-auto p-2">
                                        @foreach ($models as $index=>$model)
                                        <li class="nav-item {{ $index == 0 ? 'active' :'' }}"><a
                                                class="white nav-link {{ $index == 0 ? 'active' :'' }}" href="#{{ $model }}"
                                                data-toggle="tab">{{ $model }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- /.tab-pane -->
                                        @foreach ($models as $index=>$model)
                                        <div class="black tab-pane {{ $index == 0 ? 'active' :'' }}" id="{{ $model }}">
                                            @foreach ($maps as $map)
                                            <label><input type="checkbox" name="permissions[]"
                                                {{ $karyawan->hasPermission($map .'_'. $model) ? 'checked' : '' }} 
                                                value="{{ $map .'_'. $model }}">
                                                {{ $map }}</label>
                                            @endforeach
                                        </div>
                                        @endforeach

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="submit" class="btn btn-success"><i
                            class="fas fa-user-plus"></i> {{ __('Ubah Karyawan') }}</button>
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
                $('#foto-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#foto-img").change(function(){
        readURL(this);
    });
</script>
@endsection