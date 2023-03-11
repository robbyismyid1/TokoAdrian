<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tagihan | {{ $penjualan->nomor_penjualan }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        body {
            background-color: #ff
        }

        .padding {
            padding: 2rem !important
        }

        .card {
            margin-bottom: 30px;
            border: none;
            -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22)
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e6e6f2
        }

        h3 {
            font-size: 20px
        }

        h5 {
            font-size: 15px;
            line-height: 26px;
            color: #3d405c;
            margin: 0px 0px 15px 0px;
            font-family: 'Circular Std Medium'
        }

        .text-dark {
            color: #3d405c !important
        }

        .fix-footer {
            position: fixed;
            left: 0px;
            bottom: 0px;
            height: 35px;
            width: 100%;
            background: #1abc9c;
        }

        .head-dark {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }

        table.table-bordered {
            border: 2px solid #000000;
            border-radius: 10px;
        }

        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 2px solid #000000;
            border-radius: 10px;
        }

        .too-border {
            padding: 2px;
            border: 2px solid #000000;
            border-radius: 10px;
            margin: 5px 0;
        }

        .table th,
        .table td {
            padding: 0.25rem;
        }

        @media print {

            .table thead tr td,
            .table tbody tr td,
            .table thead tr th,
            .table tbody tr th {
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                -webkit-print-color-adjust: exact;
            }

            .col-print-1 {
                width: 8%;
                float: left;
            }

            .col-print-2 {
                width: 16%;
                float: left;
            }

            .col-print-3 {
                width: 25%;
                float: left;
            }

            .col-print-4 {
                width: 33%;
                float: left;
            }

            .col-print-5 {
                width: 42%;
                float: left;
            }

            .col-print-6 {
                width: 50%;
                float: left;
            }

            .col-print-7 {
                width: 58%;
                float: left;
            }

            .col-print-8 {
                width: 66%;
                float: left;
            }

            .col-print-9 {
                width: 75%;
                float: left;
            }

            .col-print-10 {
                width: 83%;
                float: left;
            }

            .col-print-11 {
                width: 92%;
                float: left;
            }

            .col-print-12 {
                width: 100%;
                float: left;
            }

            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .too-footer {
                position: absolute;
                bottom: 0;
            }
        }

    </style>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="card">
            <div class="card-header p-4" style="border: 2px solid #000000;border-radius: 10px;">
                <img src="{{ asset('/uploads/settings/'.$logo) }}" style="width:200px;" alt="" srcset="">
                <div class="float-right text-center">
                    <h3 class="mb-0">{{ $store_name }}</h3>
                    {{ $activity }} <br>
                    {{ $address }} <br>
                    {{ $phone }} <br>
                </div>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="text-center too-border">
                    <h4>Tagihan {{ $penjualan->nomor_penjualan }}</h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-print-6 text-center">
                        <div class="too-border">
                            <h4>Tanggal : <span style="font-size:15px">{{ $penjualan->created_at }}</span>
                            </h4>

                            <h4>Customer Service : <span style="font-size:15px">{{ Auth::user()->name }}</span> </h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-print-6 text-center">
                        <div class="too-border">
                            <h4>Informasi Pembeli</h4>
                        </div>
                        <div class="too-border">
                            Nama : {{ $penjualan_klien->nama_klien }}<br>Alamat : {{ $penjualan_klien->alamat }}
                            <br>Telepon : {{ $penjualan_klien->telepon }} <br>
                        </div>
                    </div>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-bordered" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="width: 500px;">Produk</th>
                                <th style="width: 100px;text-align:center;">Satuan</th>
                                <th style="width: 100px;text-align:center;">Qty</th>
                                <th style="width: 100px;text-align:center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan_produk as $penjualan_produk )
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $penjualan_produk->nama_produk }}</td>
                                <td style="text-align:center;">Rp{{ number_format($penjualan_produk->harga_penjualan, 2, ',', '.') }}.
                                </td>
                                <td style="text-align:center;">{{ number_format($penjualan_produk->pivot->quantity, 0, '', '.') }}</td>
                                <td style="text-align:center;">
                                    Rp{{ number_format($penjualan_produk->pivot->quantity * $penjualan_produk->harga_penjualan, 2, ',', '.') }}.
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right text-center" style="width:17.5%">
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Rp{{ number_format($penjualan->total, 2, ',', '.') }}.</strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Rp{{ number_format($penjualan->diskon, 2, ',', '.') }}.</strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Rp{{ number_format($penjualan->jumlah_total, 2, ',', '.') }}.</strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Rp{{ number_format($penjualan->dibayar, 2, ',', '.') }}.</strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;">
                                <strong>Rp{{ number_format($penjualan->jumlah_total - $penjualan->dibayar, 2, ',', '.') }}.</strong></p>
                        </div>
                    </div>
                    <div class="float-right text-center" style="width:12%">
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Subtotal </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Diskon </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Jumlah Total </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Dibayar </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Hutang </strong></p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="too-footer offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="too-border text-center">
            <p class="mb-0">{{ $activity }}. {{ $store_name }}. {{ $penjualan->created_at }}</p>
        </div>
    </div>
     {{-- <script type="text/javascript">
        window.addEventListener("load", window.print());

    </script>  --}}
</body>

</html>
