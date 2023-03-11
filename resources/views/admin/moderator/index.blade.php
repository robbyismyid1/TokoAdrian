@extends('layouts.main', ['activePage' => 'karyawan', 'titlePage' => __('Karyawan')])
@section('title')
    {{ __('Karyawan | TOKO ADRIAN') }}
@endsection
@section('page-head')

@endsection
@section('css')
    
@endsection
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header bg-primary py-3">
        <form action="{{ route('karyawan.index') }}" method="get">
        <h5 class="m-0 font-weight-bold text-white">{{ __('Data Karyawan') }}
            @if (auth()->user()->hasPermission('create_users'))
            <a type="" class="btn btn-sm btn-success float-right" style=""
            href="{{ route('karyawan.create') }}"><i class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @else
            <a type="" class="btn btn-success disabled btn float-right" 
            href="{{ route('karyawan.create') }}"><i
                    class="fas fa-plus"></i> {{ __('Tambah Data') }}</a>
            @endif
        </h5>
        </form>
      </div>

      <div class="card-body">
        @include('layouts.flash')
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_karyawan" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">{{ __('No.') }}</th>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Username') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Foto') }}</th>
                <th width="50px">{{ __('Aksi') }}</th>
              </tr>
            </thead>
            
            <tbody>
                @foreach ($karyawans as $index => $karyawan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $karyawan->name }}</td>
                    <td>{{ $karyawan->username }}</td>
                    <td>{{ $karyawan->email }}</td>
                    <td><img src="{{ asset('uploads') }}/moderator_images/{{ $karyawan->image }}" style="width:50px;" class="img-circle img-thumbnail"
                        alt="" srcset=""></td>
                    <td>
                        @if (auth()->user()->hasPermission('update_users'))
                        <a style="width: 80px" class="btn btn-warning btn-sm"
                            href="{{ route('karyawan.edit', $karyawan->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @else
                        <a style="width: 80px" class="btn btn-warning btn-sm disabled"
                            href="{{ route('karyawan.edit', $karyawan->id) }}"><i
                                class="fas fa-edit"></i> {{ __('Ubah') }}</a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_users'))
                        <button style="width: 80px" id="delete" onclick="deletemoderator({{ $karyawan->id }})"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                            {{ __('Hapus') }}</button>
                        <form id="form-delete-{{ $karyawan->id }}"
                            action="{{ route('karyawan.destroy', $karyawan->id) }}" method="post"
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
                  'Data Karyawan Kamu Aman! :)',
                  'success'
              )
          }
      });
  }

</script>
@endsection