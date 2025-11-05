<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    
    protected $table = 'materials';

    public $incrementing = false;
    protected $primaryKey = 'id_material';
    protected $keyType = 'string';

    protected $fillable = [
        'id_material',
        'nama',
        'satuan',
        'harga_satuan',
        'stok',
        'supplier_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id_supplier');
    }

    public static function getNextId(): string
    {
        $latestMaterial = Material::orderBy('id_material', 'DESC')->first();
        
        if (!$latestMaterial) {
            $nextIdNumber = 1;
        } else {
            $lastIdNumber = (int) substr($latestMaterial->id_material, 8);
            $nextIdNumber = $lastIdNumber + 1;
        }
        
        return 'HRM-MAT-' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_material)) {
                $model->id_material = self::getNextId();
            }
        });
    }
}
