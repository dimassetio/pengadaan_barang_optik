<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Lensa;
use App\Models\Pasien;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
  public function index()
  {
    $pesanans = Pesanan::with('pasien')
      ->with('frame')
      ->with('lensa')
      ->orderBy('created_at', 'desc')->get();

    $pasiens = Pasien::orderBy('nama')->get();
    $frames = Frame::orderBy('kode')->get();
    $lensas = Lensa::orderBy('merk')->get();
    return view('pesanan.index', compact(['pesanans', 'pasiens', 'frames', 'lensas']));
  }

  public function store(Request $request)
  {
    try {
      // Validate the request
      $validated = $request->validate([
        'no_pembelian' => 'required|string|max:255',
        'pasien_id' => 'required|exists:pasiens,id',
        'frame_id' => 'required|exists:frames,id',
        'lensa_id' => 'required|exists:lensas,id',
        'tanggal_proses' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_proses',
        'teknisi' => 'required|string|max:255',
      ]);

      DB::beginTransaction();

      // Create a new Pesanan record
      Pesanan::create($validated);

      // Find and update the related Frame
      $frame = Frame::findOrFail($validated['frame_id']);
      if ($frame->quantity > 0) {
        $frame->quantity -= 1;
        $frame->save();
      } else {
        return redirect()->back()->with('error', 'Stock Frame tidak mencukupi.');
      }

      // Find and update the related Lensa
      $lensa = Lensa::findOrFail($validated['lensa_id']);
      if ($lensa->quantity > 0) {
        $lensa->quantity -= 1;
        $lensa->save();
      } else {
        return redirect()->back()->with('error', 'Stock Lensa tidak mencukupi.');
      }

      // Commit the transaction
      DB::commit();

      return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan.');
    } catch (\Exception $e) {
      // Handle any errors
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      // Find the Pesanan by ID
      $pesanan = Pesanan::findOrFail($id);

      // Validate the request
      $validated = $request->validate([
        'no_pembelian' => 'required|string|max:255',
        'pasien_id' => 'required|exists:pasiens,id',
        'frame_id' => 'required|exists:frames,id',
        'jenis_lensa' => 'required|string|max:255',
        'lensa_id' => 'required|exists:lensas,id',
        'tanggal_proses' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_proses',
        'teknisi' => 'required|string|max:255',
      ]);

      // Update the Pesanan record
      $pesanan->update($validated);

      return redirect()->back()->with('success', 'Pesanan berhasil diperbarui.');
    } catch (\Exception $e) {
      // Handle any errors
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }


  public function destroy($id)
  {
    // Find the pesanan by ID
    $pesanan = Pesanan::findOrFail($id);

    // Delete the pesanan record
    $pesanan->delete();

    // Redirect back with a success message
    return redirect()->route('pesanan.index')->with('success', 'Data deleted successfully.');
  }
}
