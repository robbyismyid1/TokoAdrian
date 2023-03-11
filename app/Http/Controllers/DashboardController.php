<?php

namespace App\Http\Controllers;

use Response;
use App\Kategori;
use App\Produk;
use App\Penjualan;
use App\Pembelian;
use App\Pemasok;
use App\Klien;
use App\Pengeluaran;
use App\KotakUang;
use App\User;   
use App\GeneralSetting;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        $moderator = User::whereRoleIs('employer')->get();
        $categories = Kategori::all();
        $products = Produk::all();
        $sales = Penjualan::all();
        $purchases = Pembelian::all();
        $spendmoneys = Pengeluaran::all();
        $pemasoks = Pemasok::all();
        $kliens = Klien::all();
        // Kueri Dashboard
        $today = Carbon::today();
        $totalspendmoneys = collect($spendmoneys)->sum('harga_pengeluaran');
        $sales_today = Penjualan::whereDate('created_at', '=', $today);
        $totalsaletoday = Penjualan::whereDate('created_at', '=', $today)->sum('dibayar');
        $sale_due_today = Penjualan::whereDate('created_at', '=', $today)->sum('due');
        $spending_today = Pengeluaran::whereDate('created_at', '=', $today)->sum('harga_pengeluaran');
        $purchases_today = Pembelian::whereDate('created_at', '=', $today);
        $totalpurchasetoday = Pembelian::whereDate('created_at', '=', $today)->sum('dibayar');
        $topsales = DB::table('penjualan_produk')
            ->leftJoin('produks', 'produks.id', '=', 'penjualan_produk.produk_id')
            ->select(
                'produks.id',
                'produks.nama_produk',
                'penjualan_produk.produk_id',
                DB::raw('SUM(penjualan_produk.quantity) as total')
            )
            ->groupBy('produks.id', 'penjualan_produk.produk_id', 'produks.nama_produk')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

        $toppurchases = DB::table('pembelian_produk')
            ->leftJoin('produks', 'produks.id', '=', 'pembelian_produk.produk_id')
            ->select(
                'produks.id',
                'produks.nama_produk',
                'pembelian_produk.produk_id',
                DB::raw('SUM(pembelian_produk.quantity) as total')
            )
            ->groupBy('produks.id', 'pembelian_produk.produk_id', 'produks.nama_produk')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

        $sale_profit = DB::table('penjualan_produk')
            ->leftJoin('produks', 'produks.id', '=', 'penjualan_produk.produk_id')
            ->leftJoin('penjualans', 'penjualans.id', '=', 'penjualan_produk.penjualan_id')
            ->select(
                'penjualans.id',
                'produks.nama_produk',
                'produks.harga_penjualan',
                'produks.harga_pembelian',
                'penjualan_produk.produk_id',
                'penjualan_produk.quantity as qty',
                'penjualans.created_at',
                DB::raw('SUM(produks.harga_penjualan - produks.harga_pembelian) * penjualan_produk.quantity as profits'),
                DB::raw('DATE(penjualans.created_at) as date')

            )
            ->groupBy('penjualans.id', 'penjualan_produk.produk_id', 'produks.nama_produk', 'penjualans.created_at', 'date', 'qty')
            ->orderBy('date')
            ->whereDate('penjualans.created_at', '=', $today)
            ->get();

        $sumprofit = $sale_profit->sum('profits') - $sale_due_today;

        $stock_alerts = DB::table('produks')->where('stok', '<=', 'minstok')->get();

        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();

        return view(
            'admin.index',
            compact(
                'moderator',
                'categories',
                'products',
                'sumprofit',
                'topsales',
                'toppurchases',
                'stock_alerts',
                'sales',
                'sales_today',
                'totalsaletoday',
                'purchases',
                'purchases_today',
                'totalspendmoneys',
                'totalpurchasetoday',
                'pemasoks',
                'kliens',
                'spendmoneys',
                'spending_today',
                'alert_stock',
                'sumalert_stock'
            )
        );
    }

    public function pdf_penjualan(Request $request)
    {
        $penjualans = Penjualan::when($request->dari_tanggal, function ($q) use ($request) {
            return $q->where('created_at', 'like', '%' . $request->dari_tanggal . '%');
        })->latest()->get();
        $totalsalemoneys = collect($penjualans)->sum('jumlah_total');

        $pdf = PDF::loadview('admin.penjualan_pdf', ['penjualans'=>$penjualans, 'totalsalemoneys'=>$totalsalemoneys]);
        return $pdf->setPaper('a4')->stream();
    }

    public function pdf_pembelian(Request $request)
    {
        $pembelians = Pembelian::when($request->dari_tanggal, function ($q) use ($request) {
            return $q->where('created_at', 'like', '%' . $request->dari_tanggal . '%');
        })->latest()->get();
        $totalpurchasemoneys = collect($pembelians)->sum('jumlah_total');
        
        $pdf = PDF::loadview('admin.pembelian_pdf', ['pembelians'=>$pembelians, 'totalpurchasemoneys'=>$totalpurchasemoneys]);
        return $pdf->setPaper('a4')->stream();
    }
}
