<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTeknisiTransaksi extends Model {

    use HasFactory;
    protected $table = 'detail_teknisi_transaksi';
    
    protected $fillable = ['transaksi_id', 'karyawan_id', 'qty_hari', 'upah_satuan'];
    public $timestamps = false;

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id_karyawan');
    }
}