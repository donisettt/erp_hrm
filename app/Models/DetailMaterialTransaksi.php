<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailMaterialTransaksi extends Model {

    use HasFactory;
    protected $table = 'detail_material_transaksi';
    
    protected $fillable = ['transaksi_id', 'material_id', 'qty', 'harga_satuan'];
    public $timestamps = false;

    public function material() {
        return $this->belongsTo(Material::class, 'material_id', 'id_material');
    }
}