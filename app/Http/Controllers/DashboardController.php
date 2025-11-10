<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Customer;
use App\Models\Karyawan;
use App\Models\Proyek;
use App\Models\DetailMaterialTransaksi;
use App\Models\DetailTeknisiTransaksi;
use App\Models\DetailTambahanTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $progresProyek = Transaksi::where('status_transaksi', 'Diproses')->count();
        $totalCustomer = Customer::count();
        $totalTeknisi = Karyawan::count();

        $transaksiSelesai = Transaksi::where('status_transaksi', 'Selesai')->with('proyek')->withSum('detailMaterials as total_material', DB::raw('qty * harga_satuan'))->withSum('detailTeknisi as total_teknisi', DB::raw('qty_hari * upah_satuan'))->withSum('detailTambahan as total_tambahan', DB::raw('qty * harga_satuan'))->get();

        $totalRevenue = $transaksiSelesai->sum('proyek.harga_borongan');
        $totalCost = $transaksiSelesai->sum('total_material') + $transaksiSelesai->sum('total_teknisi') + $transaksiSelesai->sum('total_tambahan');
        $totalProfitLoss = $totalRevenue - $totalCost;

        $proyekBerjalan = Proyek::with('customer', 'transaksi')
            ->whereHas('transaksi', function ($q) {
                $q->where('status_transaksi', 'Diproses');
            })
            ->latest()
            ->take(5)
            ->get();

        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');
            $year = $date->format('Y');
            $month = $date->format('m');

            $chartLabels[] = $monthName;

            $proyekBulanIni = Proyek::whereYear('tanggal_mulai', $year)->whereMonth('tanggal_mulai', $month)->get();

            $totalPemasukanBulanIni = $proyekBulanIni->sum('harga_borongan');
            $chartPemasukan[] = $totalPemasukanBulanIni;

            $proyekIdsBulanIni = $proyekBulanIni->pluck('id_proyek');

            $transaksiIdsBulanIni = Transaksi::whereIn('proyek_id', $proyekIdsBulanIni)->pluck('id');

            $costMaterial = DetailMaterialTransaksi::whereIn('transaksi_id', $transaksiIdsBulanIni)->sum(DB::raw('qty * harga_satuan'));
            $costTeknisi = DetailTeknisiTransaksi::whereIn('transaksi_id', $transaksiIdsBulanIni)->sum(DB::raw('qty_hari * upah_satuan'));
            $costTambahan = DetailTambahanTransaksi::whereIn('transaksi_id', $transaksiIdsBulanIni)->sum(DB::raw('qty * harga_satuan'));

            $chartPengeluaran[] = $costMaterial + $costTeknisi + $costTambahan;
        }

        return view('dashboard', [
            'progresProyek' => $progresProyek,
            'totalCustomer' => $totalCustomer,
            'totalTeknisi' => $totalTeknisi,
            'totalProfitLoss' => $totalProfitLoss,
            'proyekBerjalan' => $proyekBerjalan,
            'chartLabels' => json_encode($chartLabels),
            'chartPemasukan' => json_encode($chartPemasukan),
            'chartPengeluaran' => json_encode($chartPengeluaran),
        ]);
    }
}
