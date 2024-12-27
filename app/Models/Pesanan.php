<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
  protected $fillable = [
    'no_pembelian',
    'pasien_id',
    'frame_id',
    'lensa_id',
    'tanggal_proses',
    'tanggal_selesai',
    'teknisi',
  ];

  protected function casts(): array
  {
    return [
      'tanggal_proses' => 'date',
      'tanggal_selesai' => 'date',
    ];
  }

  public function pasien()
  {
    return $this->belongsTo(Pasien::class);
  }

  public function frame()
  {
    return $this->belongsTo(Frame::class);
  }

  public function lensa()
  {
    return $this->belongsTo(Lensa::class);
  }
}
