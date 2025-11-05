<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'proyek';
    public $incrementing = false;
    protected $primaryKey = 'id_proyek';
    protected $keyType = 'string';

    protected $fillable = ['id_proyek', 'invoice', 'nama_proyek', 'harga_borongan', 'tanggal_mulai', 'tanggal_selesai', 'customer_id', 'spbu_id'];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'harga_borongan' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id_customer');
    }

    public function spbu()
    {
        return $this->belongsTo(Spbu::class, 'spbu_id', 'id');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'proyek_id', 'id_proyek');
    }

    public static function generateNextId(Customer $customer): string
    {
        $namaPerusahaan = $customer->nama_perusahaan;
        $prefix = strtoupper(substr(preg_replace('/^(PT|CV)\.?\s*/i', '', $namaPerusahaan), 0, 3));

        $lastProyek = Proyek::where('id_proyek', 'like', 'HRM-' . $prefix . '-%')
            ->orderBy('id_proyek', 'DESC')
            ->first();

        if (!$lastProyek) {
            $nextIdNumber = 1;
        } else {
            $lastIdNumber = (int) substr($lastProyek->id_proyek, -3);
            $nextIdNumber = $lastIdNumber + 1;
        }

        return 'HRM-' . $prefix . '-' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
    }
}
