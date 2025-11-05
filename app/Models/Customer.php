<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id_customer';
    protected $keyType = 'string';

    protected $fillable = [
        'id_customer',
        'nama_perusahaan',
        'nama_penanggung_jawab',
        'no_spbu',
        'jam_operasional',
        'no_hp',
        'email',
        'alamat',
    ];

    public static function getNextId(): string
    {
        $latestCustomer = Customer::orderBy('id_customer', 'DESC')->first();
        
        if (!$latestCustomer) {
            $nextIdNumber = 1;
        } else {
            $lastIdNumber = (int) substr($latestCustomer->id_customer, 7);
            $nextIdNumber = $lastIdNumber + 1;
        }
        
        return 'HRM-CS-' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_customer)) {
                $model->id_customer = self::getNextId();
            }
        });
    }
}
