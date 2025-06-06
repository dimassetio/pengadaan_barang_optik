<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('lensas', function (Blueprint $table) {
      $table->id();
      $table->string('merk');
      $table->string('jenis');
      $table->string('ukuran');
      $table->integer('quantity');
      $table->date('tanggal_masuk');
      $table->string('penerima');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lensas');
  }
};