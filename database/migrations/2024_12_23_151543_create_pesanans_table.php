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
    Schema::create('pesanans', function (Blueprint $table) {
      $table->id();
      $table->string('no_pembelian')->unique();
      $table->unsignedBigInteger('pasien_id');
      $table->unsignedBigInteger('frame_id');
      $table->unsignedBigInteger('lensa_id');
      $table->date('tanggal_proses')->nullable();
      $table->date('tanggal_selesai')->nullable();
      $table->string('teknisi');
      $table->timestamps();

      // Foreign key constraints
      $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
      $table->foreign('frame_id')->references('id')->on('frames')->onDelete('cascade');
      $table->foreign('lensa_id')->references('id')->on('lensas')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pesanans');
  }
};
