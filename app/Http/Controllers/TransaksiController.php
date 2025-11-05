<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Transaksi;
use App\Models\Material;
use App\Models\Karyawan;
use App\Models\DetailMaterialTransaksi;
use App\Models\DetailTeknisiTransaksi;
use App\Models\DetailTambahanTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksiList = Transaksi::with(['proyek.customer', 'proyek.spbu'])
            ->withSum('detailMaterials as total_material', DB::raw('qty * harga_satuan'))
            ->withSum('detailTeknisi as total_teknisi', DB::raw('qty_hari * upah_satuan'))
            ->withSum('detailTambahan as total_tambahan', DB::raw('qty * harga_satuan'))
            ->latest()
            ->paginate(10);

        $proyekTersedia = Proyek::whereDoesntHave('transaksi')->orderBy('nama_proyek')->get();

        return view('pages.transaksi.index', [
            'transaksiList' => $transaksiList,
            'proyekTersedia' => $proyekTersedia,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required|string|exists:proyek,id_proyek|unique:transaksi,proyek_id',
        ]);

        $transaksi = Transaksi::create([
            'proyek_id' => $request->proyek_id,
            'pembayaran' => 'Belum Bayar',
            'status_transaksi' => 'Diproses',
        ]);

        return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Transaksi berhasil dibuat. Silakan kelola detail biaya.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['proyek.customer', 'proyek.spbu', 'detailMaterials.material', 'detailTeknisi.karyawan', 'detailTambahan']);

        $all_materials = Material::orderBy('nama')->get();
        $all_karyawan = Karyawan::where('status', 'aktif')->orderBy('nama')->get();

        return view('pages.transaksi.show', [
            'transaksi' => $transaksi,
            'all_materials' => $all_materials,
            'all_karyawan' => $all_karyawan,
        ]);
    }

    public function addMaterial(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'material_id' => 'required|string|exists:materials,id_material',
            'qty' => 'required|integer|min:1',
        ]);

        $material = Material::find($request->material_id);

        DetailMaterialTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'material_id' => $material->id_material,
            'qty' => $request->qty,
            'harga_satuan' => $material->harga_satuan, // Ambil harga dari master material
        ]);

        return back()->with('success', 'Material berhasil ditambahkan.');
    }

    /**
     * [BARU] Menghapus Material dari Transaksi
     */
    public function removeMaterial(DetailMaterialTransaksi $item)
    {
        $item->delete();
        return back()->with('success', 'Material berhasil dihapus.');
    }

    /**
     * [BARU] Menambahkan Karyawan ke Transaksi
     */
    public function addKaryawan(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'karyawan_id' => 'required|string|exists:karyawan,id_karyawan',
            'qty_hari' => 'required|integer|min:1', // Sesuai tabel Anda
        ]);

        $karyawan = Karyawan::find($request->karyawan_id);

        DetailTeknisiTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'karyawan_id' => $karyawan->id_karyawan,
            'qty_hari' => $request->qty_hari,
            'upah_satuan' => $karyawan->upah_harian, // Ambil upah dari master karyawan
        ]);

        return back()->with('success', 'Teknisi berhasil ditambahkan.');
    }

    /**
     * [BARU] Menghapus Karyawan dari Transaksi
     */
    public function removeKaryawan(DetailTeknisiTransaksi $item)
    {
        $item->delete();
        return back()->with('success', 'Teknisi berhasil dihapus.');
    }

    /**
     * [BARU] Menambahkan Pengeluaran Tambahan ke Transaksi
     */
    public function addPengeluaran(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        DetailTambahanTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
        ]);

        return back()->with('success', 'Pengeluaran tambahan berhasil dicatat.');
    }

    /**
     * [BARU] Menghapus Pengeluaran Tambahan dari Transaksi
     */
    public function removePengeluaran(DetailTambahanTransaksi $item)
    {
        $item->delete();
        return back()->with('success', 'Pengeluaran tambahan berhasil dihapus.');
    }

    /**
     * [BARU] Mengupdate Status Transaksi (Pembayaran & Status)
     */
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'pembayaran' => 'required|in:Belum Bayar,DP,Lunas',
            'status_transaksi' => 'required|in:Diproses,Selesai,Batal',
        ]);

        $transaksi->update([
            'pembayaran' => $request->pembayaran,
            'status_transaksi' => $request->status_transaksi,
        ]);

        // Redirect kembali ke halaman index (Data Transaksi)
        return redirect()->route('transaksi.index')->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
