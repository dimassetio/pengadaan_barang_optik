<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lensa extends Model
{
  protected $fillable = [
    'merk',
    'jenis',
    'ukuran',
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
