@extends('layouts.main', ['activePage' => 'karyawan-profile', 'titlePage' => __('Profile')])
@section('title')
    {{ __('Profile | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-widget widget-user">
        <div class="widget-user-header bg-dark">
            <h3 class="widget-user-username white">{{ $profile->name }}</h3>
            <h4 class="widget-user-username white">{{ $profile->username }}</h4>
            <h4 class="widget-user-username white">{{ $profile->email }}</h4>
        </div>
        <div class="widget-user-image">
            <img class="img-circle elevation-2" src="{{ $profile->image_path }}" alt="User Avatar">
        </div>
        <div class="card-body pt-5 text-center">
            @if($profile->hasRole('super_admin'))
            <h5 class="widget-user-desc black">Role : Administrator</h5>
            @else
            <h5 class="widget-user-desc black">Role : Employee</h5>
            @endif
            <h3 class="black">Lists Of All Permissions</h3>
        </div>
        <div class="card-footer">
            <div class="row">
                @foreach ($allprofilepermission as $profilepermission)
                <div class="col-sm-3 border-right">
                    <div class="description-block">
                        <h5 class="description-header black">{{ $profilepermission->display_name }}</h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection