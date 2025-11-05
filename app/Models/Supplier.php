<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id_supplier';
    protected $keyType = 'string';

    protected $fillable = [
        'id_supplier',
        'nama',
        'no_hp',
        'email',
        'alamat',
    ];

    public static function getNextId(): string
    {
        $latestSupplier = Supplier::orderBy('id_supplier', 'DESC')->first();
        
        if (!$latestSupplier) {
            $nextIdNumber = 1;
        } else {
            $lastIdNumber = (int) substr($latestSupplier->id_supplier, 7);
            $nextIdNumber = $lastIdNumber + 1;
        }
        
        return 'HRM-SP-' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_supplier)) {
                $model->id_supplier = self::getNextId();
            }
        });
    }
}
