<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
  protected $fillable = [
    'kode',
    'warna',
    'quantity',
    'tanggal_masuk',
    'penerima',
  ];

  protected function casts(): array
  {
    return [
      'tanggal_masuk' => 'date',
    ];
  }
}