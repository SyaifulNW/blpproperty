<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPenjualan extends Model
{
    use HasFactory;

    protected $table = 'history_penjualans';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'bulan',
        'tahun',
        'omset',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Produk::class, 'kelas_id');
    }
}
