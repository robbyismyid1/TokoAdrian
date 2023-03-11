@extends('layouts.mainpos')
@section('kembali')
    {{ route('penjualan.index') }}
@endsection
@section('content')
<div class="form-row">
    <div class="col-md-6">
        <div class="card card-primary card-outline" style="height:80vh;">
            <div class="card-header bg-success py-3">
                <h5 class="m-0 font-weight-bold text-white">{{ __('Penjualan') }}</h5>

            </div> <!-- /.card-body -->
            <div class="card-body" style="overflow-y:scroll;">
                <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    @include('partials._errors')
                    <div class="row">
                        <div class="col-md-6">
                            <div id="klien" class="form-group">
                                <label class="black" for="">{{ __('Pilih Pelanggan') }}</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <select name="klien_id" class="form-control">
                                            @foreach ($kliens as $klien)
                                            <option value="{{ $klien->id }}"
                                                {{ old('kategori_id') == $klien->id ? 'selected' : ''}}>{{
                                        $klien->nama_klien }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">

                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target=".bd-example-modal-lg-klien">{{ __('Tambah Pelanggan') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="black" for="">{{ __('Nomor Penjualan') }} : </label>
                                <input type="text" name="nomor_penjualan" class="form-control text-center" readonly
                                    value="{{ $penjualan->nomor_penjualan }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table id="sale" class="table table-sm table-bordered">
                            <thead>
                                <span class="red bold">CATATAN:</span>
                                <span class="black"> Produk terakhir adalah </span>
                                @foreach ($penjualan->produk as $item)
                                    <span class="red">{{ $item->nama_produk }} [{{ $item->pivot->quantity }}], </span>
                                @endforeach
                                
                                <tr>
                                    <th class="black">{{ __('Nama Produk') }}</th>
                                    <th class="black">{{ __('Jumlah') }}</th>
                                    <th class="black">{{ __('Harga Jual') }}</th>
                                    <th class="black" style="width: 25px;">{{ __('Hapus') }}</th>
                                </tr>
                            </thead>

                            <tbody class="order-list">
                                @foreach ($penjualan->produk as $produk)
                                <tr id="{{ $produk->id }}" class="form-group items">
                                <td id="name" class="namex">{{ $produk->nama_produk }}</td>
                                <input type="hidden" name="product[]" value="{{ $produk->id }}">
                                <td style="display: flex;">
                                    <input id="qty" style="width: 60% !important;" type="number" name="quantity[]"
                                        data-price="{{ $produk->harga_penjualan }}" data-stock="{{ $produk->stok }}"
                                        class="form-control input-sm product-quantity" min="1"
                                        max="{{ $produk->pivot->quantity + $produk->stok }}" value="{{ $produk->pivot->quantity }}">
                                </td>
                                <td class="product-price">{{ $produk->harga_penjualan * $produk->pivot->quantity }}</td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-product-btn"
                                        data-id="{{ $produk->id }}"><span class="fa fa-trash"></span></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>

                        </table>
                        <div class="row">
                            <div class="col-md-5 offset-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">{{ __('Total') }} : </label>
                                    <input type="number" name="total" class="form-control col-sm-6 total-price" min="0"
                                        readonly value="{{ $penjualan->total }}">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">{{ __('Diskon') }} : </label>
                                    <input type="number" id="discount" name="diskon"
                                        class="form-control col-sm-6 discount" min="0" value="{{ $penjualan->diskon }}">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">{{ __('Jumlah') }} : </label>
                                    <input type="number" id="total-amount" name="jumlah_total"
                                        class="form-control col-sm-6 total-amount" readonly min="0" value="{{ $penjualan->jumlah_total }}">
                                </div>
                                <div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">{{ __('Tipe') }} : </label>
                                        <select id="select" class="form-control col-sm-6" name="status">
                                            <option value="dibayar">{{ __('Dibayar') }}</option>
                                            <option value="tidak dibayar">{{ __('Tidak Dibayar') }}</option>
                                            <option value="hutang">{{ __('Hutang') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">{{ __('Bayar') }} : </label>
                                        <input id="paid" type="number" name="dibayar" class="form-control col-sm-6 paid"
                                            value="{{ $penjualan->dibayar }}">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">{{ __('Hutang') }} : </label>
                                        <input id="credit" type="number" name="credit" class="form-control col-sm-6 credit"
                                            readonly value="{{ $penjualan->due }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer form-group">
                            <button type="submit" class="btn btn-success" href="{{ route('penjualan.store') }}"><i
                                    class="fas fa-user-plus"></i>
                                    {{ __('Simpan') }}</button>
                        </div>
                    </div>
                </form>
                <div class="modal fade bd-example-modal-lg-klien" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-success py-3">
                                <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Klien') }}</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="new_klien" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('post') }}
                                @include('partials._errors')
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="">{{ __('Nama Klien') }}</label>
                                            <input class="form-control{{ $errors->has('nama_klien') ? ' is-invalid' : '' }}" name="nama_klien" type="text" placeholder="{{ __('') }}" value="{{ old('nama_klien') }}" required="true" aria-required="true"/>
                                            @if ($errors->has('nama_klien'))
                                                <small class="text-danger">{{ $errors->first('nama_klien') }}</small>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="">{{ __('Nomor Induk Kependudukan') }}</label>
                                            <input class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik" type="number" placeholder="{{ __('') }}" value="{{ old('nik') }}" required="true" aria-required="true"/>
                                            @if ($errors->has('nik'))
                                                <small class="text-danger">{{ $errors->first('nik') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label for="">{{ __('Telepon') }}</label>
                                            <input class="form-control{{ $errors->has('telepon') ? ' is-invalid' : '' }}" name="telepon" type="text" placeholder="{{ __('') }}" value="{{ old('telepon') }}" required="true" aria-required="true"/>
                                            @if ($errors->has('telepon'))
                                                <small class="text-danger">{{ $errors->first('telepon') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label for="">{{ __('Alamat') }}</label>
                                            <textarea type="text" name="alamat" id="" class="form-control" value="{{ old('alamat') }}">{{ old('alamat') }}</textarea>
                                            @if ($errors->has('alamat'))
                                                <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label for="">{{ __('Deskripsi') }}</label>
                                            <textarea type="text" name="deskripsi" id="" class="form-control" value="{{ old('deskripsi') }}">{{ old('deskripsi') }}</textarea>
                                            @if ($errors->has('deskripsi'))
                                                <small class="text-danger">{{ $errors->first('deskripsi') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label for="">{{ __('Foto') }}</label>
                                            <input id="klien-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ old('image') }}" required="true" aria-required="true"/>
                                            @if ($errors->has('image'))
                                                <small class="text-danger">{{ $errors->first('image') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <img src="" style="width:150px;" 
                                            class="img-circle" alt=""
                                            id="klien-img-tag">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{ __('Tutup') }}</button>
                                        <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('Tambah') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.card-body -->
    </div>

    <div class="col-md-6">
        <div class="card card-primary card-outline" style="height:80vh;">
            <div class="card-header bg-primary py-3">
                <h5 class="m-0 font-weight-bold text-white">{{ __('Semua Produk') }}</h5>
            </div> <!-- /.card-body -->
            <div class="card-body" style="overflow-y:scroll;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="black" for="">{{ __('Kategori') }}</label>
                            <select id="searchbycategory" name="kategori_id" class="form-control">
                                <option value="">{{ __('-- Kategori --')}}</option>
                                @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id') == $kategori->id ? 'selected' : ''}}>{{
                                        $kategori->kode_kategori }} - {{
                                        $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="black" for="">{{ __('Cari berdasarkan nama atau kategori')}}</label>
                            <input id="searchbyproduct" class="form-control" type="text" name="searchproduct"
                                placeholder="{{ __('Cari produk') }}" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    @if ($produks->count() > 0)
                    <div id="pds" class="row text-center text-lg-left containerItems">

                        @foreach ($produks as $produk)

                        <div class="col-md-2 col-md-offset-1" style="margin:0;">
                            <a href="" data-tooltip="tooltip"
                                title="Price : {{ $produk->harga_penjualan }} stock : {{ $produk->stok }}"
                                data-placement="top" id="product-{{ $produk->id }}" +
                                data-name="{{ $produk->nama_produk }}" + data-id="{{ $produk->id }}" +
                                data-price="{{ $produk->harga_penjualan }}" + data-stock="{{ $produk->stok }}" class="con d-block mb-4 add-product-btn">
                                <img style="width: 100%" class="img-fluid" src="{{ $produk -> image_path }}" alt="">
                                <span style="width: 75%" class="mbr-gallery-title text-truncate">{{ $produk->nama_produk }}</span>
                            </a>

                        </div>
                        @endforeach

                    </div>
                    @else
                    
                    <div class="center">
                        <div class="centered">
                            <label class="black" for="">{{ __('Tidak ada produk yang dapat dijual') }}</label>
                        </div>
                    </div>


                    @endif
                </div>
            </div><!-- /.card-body -->
        </div>
    </div>
</div>
<br>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('body').tooltip({
            selector: "[data-tooltip=tooltip]",
            container: "body"
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // add new client in sale page
        $('body').on('submit', '#new_klien', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ ('/klien') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (reponse) {
                    console.log(reponse);
                    $('.bd-example-modal-lg-klien').modal('hide');
                    $('#new_klien')[0].reset();
                    $("#klien").load(" #klien");
  
                },
                error: function (error) {
                    const errors = error.responseJSON.errors
                    const firstitem = Object.keys(errors)[0]
                    const firstitemDOM = document.getElementById(firstitem)
                    const firstErrorMessage = errors[firstitem][0]
                    firstitemDOM.scrollIntoView({})
  
                    const errorMessages = document.querySelectorAll('.text-danger')
                    errorMessages.forEach((element) => element.textContent = '')
  
                    firstitemDOM.insertAdjacentHTML('afterend',
                        `<div class="text-danger">${firstErrorMessage}</div>`)
  
                    const formControls = document.querySelectorAll('.form-control')
                    formControls.forEach((element) => element.classList.remove('border',
                        'border-danger'))
  
                    firstitemDOM.classList.add('border', 'border-danger')
                }
            });
        });
  
        // Search for product to sale by Category Product and by product name
  
        $("#searchbycategory").add("#searchbyproduct").on('change input', function () {
            var searchbycategory = $('#searchbycategory').val();
            var searchbyproduct = $("#searchbyproduct").val();
            $.ajax({
                type: "GET",
                url: "/searchsale",
                //data: 'searchbycategory=' + searchbycategory,
                data: {
                    'searchbycategory': searchbycategory,
                    'searchbyproduct': searchbyproduct,
                },
                dataType: 'json',
                success: function (data) {
                    var html = data.produks.map(function (item) {
                        var sale = item.harga_penjualan;
                        var stock = item.stok;
                        var id = item.id;
                        var name = item.nama_produk;
                        var image = item.image_path;
                        return `<div class="col-md-2 col-md-offset-1" style="margin:0;"><a href="" id="product"
                           data-tooltip="tooltip" title="Price : ${sale} stock : ${stock}" data-placement="top"
                           id="product-${id}" + data-name="${name}" + data-id="${id}" + data-price="${sale}" +
                           data-stock="${stock}" class="con d-block mb-4 add-product-btn">
                           <img style="width: 100%" class="img-fluid img-product" src="${image}" alt="">
                           <span style="width: 75%" class="mbr-gallery-title text-truncate">${name}</span>
                       </a>
                   </div>`;
                    });
  
                    console.log(html);
                    $('#pds').html(html);
                    $('[data-tooltip="tooltip"]').tooltip();
  
                }
            });
        });
    });
  
  </script>
@endsection