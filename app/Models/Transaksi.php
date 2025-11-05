<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {

    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = ['proyek_id', 'pembayaran', 'status_transaksi'];

    public function proyek() {
        return $this->belongsTo(Proyek::class, 'proyek_id', 'id_proyek');
    }

    public function detailMaterials() {
        return $this->hasMany(DetailMaterialTransaksi::class);
    }
    public function detailTeknisi() {
        return $this->hasMany(DetailTeknisiTransaksi::class);
    }
    public function detailTambahan() {
        return $this->hasMany(DetailTambahanTransaksi::class);
    }
}