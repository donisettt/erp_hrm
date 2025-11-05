<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    public $incrementing = false;
    protected $primaryKey = 'id_karyawan';
    protected $keyType = 'string';

    protected $fillable = [
        'id_karyawan',
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'jabatan',
        'no_hp',
        'email',
        'alamat',
        'upah_harian',
        'status',
    ];

    public static function getNextId(): string
    {
        $latestKaryawan = Karyawan::orderBy('id_karyawan', 'DESC')->first();
        
        if (!$latestKaryawan) {
            $nextIdNumber = 1;
        } else {
            $lastIdNumber = (int) substr($latestKaryawan->id_karyawan, 4);
            $nextIdNumber = $lastIdNumber + 1;
        }
        
        return 'HRM-' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_karyawan)) {
                $model->id_karyawan = self::getNextId();
            }
        });
    }
}
