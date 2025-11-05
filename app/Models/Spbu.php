<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spbu extends Model
{
    use HasFactory;

    protected $table = 'spbu';

    protected $fillable = [
        'no_spbu',
        'manajer',
        'nama_lokasi',
        'no_hp',
        'alamat',
        'jam_operasional',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id_customer');
    }
}
