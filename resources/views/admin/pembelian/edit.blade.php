@extends('layouts.mainpos')
@section('kembali')
    {{ route('pembelian.index') }}
@endsection
@section('content')
<div class="form-row">
    <div class="col-md-6">
        <div class="card card-primary card-outline" style="height:80vh;">
            <div class="card-header bg-success py-3">
                <h5 class="m-0 font-weight-bold text-white">{{ __('Pembelian') }}</h5>

            </div> <!-- /.card-body -->
            <div class="card-body" style="overflow-y:scroll;">
                <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    @include('partials._errors')
                    <div class="row">
                        <div class="col-md-6">
                            <div id="pemasok" class="form-group">
                                <label class="black" for="">{{ __('Pilih Pemasok') }}</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <select name="pemasok_id" class="form-control">
                                            @foreach ($pemasoks as $pemasok)
                                            <option value="{{ $pemasok->id }}"
                                                {{ old('pemasok_id') == $pemasok->id ? 'selected' : ''}}>{{
                                        $pemasok->nama_pemasok }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">

                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target=".bd-example-modal-lg-pemasok">{{ __('Tambah Pemasok') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="black" for="">{{ __('Nomor Pembelian') }} : </label>
                                <input type="text" name="nomor_pembelian" class="form-control text-center" readonly
                                    value="{{ $pembelian->nomor_pembelian }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <span class="red bold">CATATAN:</span>
                                <span class="black"> Produk terakhir adalah </span>
                                @foreach ($pembelian->produk as $item)
                                    <span class="red">{{ $item->nama_produk }} [{{ $item->pivot->quantity }}], </span>
                                @endforeach
                                <tr>
                                    <th class="black">{{ __('Nama Produk') }}</th>
                                    <th class="black">{{ __('Jumlah') }}</th>
                                    <th class="black">{{ __('Harga Beli') }}</th>
                                    <th class="black" style="width: 25px;">{{ __('Hapus') }}</th>
                                </tr>
                            </thead>

                            <tbody class="order-list">
                                @foreach ($pembelian->produk as $produk)
                                <tr id="{{ $produk->id }}" class="form-group items">
                                <td id="name" class="namex">{{ $produk->nama_produk }}</td>
                                <input type="hidden" name="product[]" value="{{ $produk->id }}">
                                <td style="display: flex;">
                                    <input id="qty" style="width: 60% !important;" type="number" name="quantity[]"
                                        data-price="{{ $produk->harga_pembelian }}" data-stock="{{ $produk->stok }}"
                                        class="form-control input-sm product-quantity" min="1"
                                        max="" value="{{ $produk->pivot->quantity }}">
                                </td>
                                <td class="product-price">{{ $produk->harga_pembelian * $produk->pivot->quantity }}</td>
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
                                    <input type="number" name="total" class="form-control  col-sm-6 total-price" min="0"
                                        readonly value="{{ $pembelian->total }}">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">{{ __('Diskon') }} : </label>
                                    <input type="number" id="discount" name="diskon"
                                        class="form-control col-sm-6 discount" min="0" value="{{ $pembelian->diskon }}">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">{{ __('Jumlah') }} : </label>
                                    <input type="number" id="total-amount" name="jumlah_total"
                                        class="form-control col-sm-6 total-amount" readonly min="0" value="{{ $pembelian->jumlah_total }}">
                                </div>
                                <div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">{{ __('Tipe') }} : </label>
                                        <select id="select" class="form-control col-sm-6" name="status">
                                            <option value="dibayar" {{ ('dibayar' == $pembelian->status) ? 'selected' : '' }}>{{ __('Dibayar') }}</option>
                                            <option value="tidak dibayar" {{ ('tidak dibayar' == $pembelian->status) ? 'selected' : '' }}>{{ __('Tidak Dibayar') }}</option>
                                            <option value="hutang" {{ ('hutang' == $pembelian->status) ? 'selected' : '' }}>{{ __('Hutang') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">{{ __('Bayar') }} : </label>
                                        <input id="paid" type="number" name="dibayar" class="form-control col-sm-6 paid"
                                            value="{{ $pembelian->dibayar }}">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">{{ __('Hutang') }} : </label>
                                        <input id="credit" type="number" name="credit" class="form-control col-sm-6 credit"
                                            readonly value="{{ $pembelian->due }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer form-group">
                            <button type="submit" class="btn btn-success"><i
                                    class="fas fa-user-plus"></i>
                                    {{ __('Simpan') }}</button>
                        </div>
                    </div>
                </form>
                <div class="modal fade bd-example-modal-lg-pemasok" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success py-3">
                                <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Pemasok') }}</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="new_pemasok" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('post') }}
                                @include('partials._errors')
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label for="">{{ __('Nama Pemasok') }}</label>
                                            <input class="form-control{{ $errors->has('nama_pemasok') ? ' is-invalid' : '' }}" name="nama_pemasok" type="text" placeholder="{{ __('') }}" value="{{ old('nama_pemasok') }}" required="true" aria-required="true"/>
                                            @if ($errors->has('nama_pemasok'))
                                                <small class="text-danger">{{ $errors->first('nama_pemasok') }}</small>
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
            <div id="pronew" class="card-body" style="overflow-y:scroll;">
                <label class="black" for="">{{ __('Cari produk berdasarkan nama atau kategori') }}</label>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="searchbyproduct" class="form-control" type="text" name="product"
                                placeholder="{{ __('Cari produk . . . ') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target=".bd-example-modal-lg">{{ __('Buat Produk') }}</button>
    
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success py-3">
                                            <span class="m-0 font-weight-bold text-white">{{ __('Tambah Data Produk') }}</span>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form enctype="multipart/form-data" id="new_product">
                                            {{ csrf_field() }}
                                            {{ method_field('post') }}
                                            <div id="form-messages" class="alert success" role="alert"
                                                style="display: none;"></div>
                                            <div class="modal-body">
                                                @include('partials._errors')
                                                <div class="form-row">
                                                    <div class="form-group col-lg-6">
                                                      <label for="">{{ __('Kode Produk') }}</label>
                                                      <input readonly id="codebar" class="form-control{{ $errors->has('kode_produk') ? ' is-invalid' : '' }}" name="kode_produk" type="text" placeholder="{{ __('') }}" value="#PRDK{{ $count+1 }}" required="true" aria-required="true"/>
                                                      @if ($errors->has('kode_produk'))
                                                        <small class="text-danger">{{ $errors->first('kode_produk') }}</small>
                                                      @endif
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                      <label for="">{{ __('Kategori') }}</label>
                                                      <select id="category_id" name="kategori_id" class="form-control" required="true" aria-required="true">
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
                                                      <input id="product_name" class="form-control{{ $errors->has('nama_produk') ? ' is-invalid' : '' }}" name="nama_produk" type="text" placeholder="{{ __('') }}" value="{{ old('nama_produk') }}" required="true" aria-required="true"/>
                                                      @if ($errors->has('nama_produk'))
                                                        <small class="text-danger">{{ $errors->first('nama_produk') }}</small>
                                                      @endif
                                                    </div>
                                                  </div>
                                                  <div class="form-row">
                                                    <div class="form-group col-lg-12">
                                                      <label for="">{{ __('Deskripsi') }}</label>
                                                      <textarea id="description" type="text" name="deskripsi" id="" class="form-control" value="{{ old('deskripsi') }}"></textarea>
                                                      @if ($errors->has('deskripsi'))
                                                        <small class="text-danger">{{ $errors->first('deskripsi') }}</small>
                                                      @endif
                                                    </div>
                                                  </div>
                                                  <div class="form-row">
                                                    <div class="form-group col-lg-6">
                                                      <label for="">{{ __('Harga Pembelian') }}</label>
                                                      <input id="purchase_price" class="form-control{{ $errors->has('harga_pembelian') ? ' is-invalid' : '' }}" name="harga_pembelian" type="number" placeholder="{{ __('') }}" value="{{ old('harga_pembelian') }}" required="true" aria-required="true"/>
                                                      @if ($errors->has('harga_pembelian'))
                                                        <small class="text-danger">{{ $errors->first('harga_pembelian') }}</small>
                                                      @endif
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                      <label for="">{{ __('Harga Penjualan') }}</label>
                                                      <input id="sale_price" class="form-control{{ $errors->has('harga_penjualan') ? ' is-invalid' : '' }}" name="harga_penjualan" type="number" placeholder="{{ __('') }}" value="{{ old('harga_penjualan') }}" required="true" aria-required="true"/>
                                                      @if ($errors->has('harga_penjualan'))
                                                        <small class="text-danger">{{ $errors->first('harga_penjualan') }}</small>
                                                      @endif
                                                    </div>
                                                  </div>
                                                  <div class="form-row">
                                                    <div class="form-group col-lg-6">
                                                      <label for="">{{ __('Stok') }}</label>
                                                      <input id="stock" class="form-control{{ $errors->has('stok') ? ' is-invalid' : '' }}" name="stok" type="number" placeholder="{{ __('') }}" value="{{ old('stok') }}" required="true" aria-required="true"/>
                                                      @if ($errors->has('stok'))
                                                        <small class="text-danger">{{ $errors->first('stok') }}</small>
                                                      @endif
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                      <label for="">{{ __('Minimal Stok') }}</label>
                                                      <input id="min_stock" class="form-control{{ $errors->has('minstok') ? ' is-invalid' : '' }}" name="minstok" type="number" placeholder="{{ __('') }}" value="{{ old('minstok') }}" required="true" aria-required="true"/>
                                                      @if ($errors->has('minstok'))
                                                        <small class="text-danger">{{ $errors->first('minstok') }}</small>
                                                      @endif
                                                    </div>
                                                  </div>
                                                  <div class="form-row">
                                                    <div class="form-group col-lg-12">
                                                      <label for="">{{ __('Foto') }}</label>
                                                      <input id="produk-img" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" placeholder="{{ __('') }}" value="{{ old('image') }}" required="true" aria-required="true"/>
                                                      @if ($errors->has('image'))
                                                        <small class="text-danger">{{ $errors->first('image') }}</small>
                                                      @endif
                                                    </div>
                                                  </div>
                                                  <div class="form-row">
                                                    <div class="form-group col-lg-12">
                                                      <img src="" style="width: 150px;" 
                                                      class="img-circle" alt=""
                                                      id="produk-img-tag">
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{ __('Tutup') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-12">
                    @if ($produks->count() > 0)
                    <div id="pds" class="row text-center text-lg-left containerItems" style="position:relative;">
    
                        @foreach ($produks as $produk)
    
                        <div class="col-md-2 col-md-offset-1" style="margin:0;">
                            {{-- <button id="updateproductprice mb-4" style="position: absolute;top: 0;right: 0;">x</button> --}}
                            <a href="" data-tooltip="tooltip" title="Price : {{ $produk->harga_pembelian }} stock :
                                {{ $produk->stok }}" data-placement="top" id="product-{{ $produk->id }}" +
                                data-name="{{ $produk->nama_produk }}" + data-id="{{ $produk->id }}" +
                                data-price="{{ $produk->harga_pembelian }}" + data-stock="{{ $produk->stok }}" +
                                data-sale="{{ $produk->harga_penjualan }}" class="con
                                d-block mb-4 add-product-purchase">
                                <img style="width: 100%" class="img-fluid" src="{{ $produk -> image_path }}" alt="">
                                <span style="width: 75%" class="mbr-gallery-title text-truncate">{{ $produk->nama_produk }}</span>
                            </a>
                        </div>
                        @endforeach
    
                    </div>
                    @else
                    <div class="center">
                        <div class="centered">
                            <label class="black" for="">{{ __('Tidak ada produk yang dapat dibeli') }}</label>
                        </div>
                    </div>
                    @endif
                    {{--    --}}
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
        $('body').on('submit', '#new_pemasok', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ ('/pemasok') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (reponse) {
                    console.log(reponse);
                    $('.bd-example-modal-lg-pemasok').modal('hide');
                    $('#new_pemasok')[0].reset();
                    $("#pemasok").load(" #pemasok");
  
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

        // add new product in purchase page
        $('body').on('submit', '#new_product', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ ('/produk') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (reponse) {
                    
                    $('.bd-example-modal-lg').modal('hide')
                    $('#new_product')[0].reset();
                    
                    $("#pronew").load(" #pronew > *");
                    $('[data-tooltip="tooltip"]').tooltip();
                    Swal.fire(
                        'Sukses',
                        'Data produk berhasil dibuat!',
                        'success'
                    )

                    
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
                    //console.log(firstitem)

                    //alert("data not saved");
                }
            });
        });
  
        // Search for product to sale by Category Product and by product name
  
        $("#searchbyproduct").on('change input', function () {
            var searchbyproduct = $("#searchbyproduct").val();
            $.ajax({
                type: "GET",
                url: "/searchpurchase",
                //data: 'searchbycategory=' + searchbycategory,
                data: {
                    'searchbyproduct': searchbyproduct,
                },
                dataType: 'json',
                success: function (data) {
                    var html = data.produks.map(function (item) {
                        var purchase = item.harga_pembelian;
                        var sale = item.harga_penjualan;
                        var stock = item.stok;
                        var id = item.id;
                        var name = item.nama_produk;
                        var image = item.image_path;
                        var link = "/updateprice"
                        return `<div class="col-md-2 col-md-offset-1" style="margin:0;">
                            <a href="" id="product" data-tooltip="tooltip" title="Price : ${purchase} stock :
                                ${stock}" data-placement="top" id="product-${id}" +
                                data-name="${name}" + data-id="${id}" +
                                data-price="${purchase}" + data-stock="${stock}" +
                                data-sale="${sale}" class="con
                                d-block mb-4 add-product-purchase">
                                <img style="width: 100%" class="img-fluid" src="${image}" alt="">
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