<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTambahanTransaksi extends Model {

    use HasFactory;
    protected $table = 'detail_tambahan_transaksi';
    
    protected $fillable = ['transaksi_id', 'nama_pengeluaran', 'qty', 'harga_satuan'];
}