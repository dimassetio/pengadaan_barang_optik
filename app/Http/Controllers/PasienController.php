<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Lensa;
use App\Models\Pasien;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
  public function index()
  {
    $pasiens = Pasien::orderBy('created_at', 'desc')->get();

    $frames = Frame::orderBy('kode')->get();
    $lensas = Lensa::orderBy('merk')->get();

    return view('pasien.index', compact(['pasiens', 'frames', 'lensas']));
  }

  public function store(Request $request)
  {
    try {
      $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'nohp' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'no_pembelian' => 'required|string|max:255',
        'frame_id' => 'required|exists:frames,id',
        'lensa_id' => 'required|exists:lensas,id',
        'tanggal_proses' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_proses',
        'teknisi' => 'required|string|max:255',
      ]);

      DB::beginTransaction();

      $pasien = Pasien::create([
        'nama' => $validated['nama'],
        'nohp' => $validated['nohp'],
        'alamat' => $validated['alamat'],
      ]);


      Pesanan::create([
        'no_pembelian' => $validated['no_pembelian'],
        'frame_id' => $validated['frame_id'],
        'lensa_id' => $validated['lensa_id'],
        'tanggal_proses' => $validated['tanggal_proses'],
        'tanggal_selesai' => $validated['tanggal_selesai'],
        'teknisi' => $validated['teknisi'],
        'pasien_id' => $pasien->id,
      ]);

      $frame = Frame::findOrFail($validated['frame_id']);
      if ($frame->quantity > 0) {
        $frame->quantity -= 1;
        $frame->save();
      } else {
        DB::rollBack();
        return redirect()->back()->with('error', 'Stock Frame tidak mencukupi.');
      }

      $lensa = Lensa::findOrFail($validated['lensa_id']);
      if ($lensa->quantity > 0) {
        $lensa->quantity -= 1;
        $lensa->save();
      } else {
        DB::rollBack();
        return redirect()->back()->with('error', 'Stock Lensa tidak mencukupi.');
      }

      DB::commit();

      return redirect()->route('pasien.index')->with('success', 'Data added successfully.');
    } catch (\Exception $e) {
      DB::rollBack();

      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'nohp' => 'required|string|max:255',
      'alamat' => 'required|string|max:255',
    ]);

    // Find the pasien by ID
    $pasien = Pasien::findOrFail($id);

    // Update the pasien with the request data
    $pasien->update($request->all());

    // Redirect back to the index page with a success message
    return redirect()->route('pasien.index')->with('success', 'Data updated successfully.');
  }

  public function destroy($id)
  {
    // Find the pasien by ID
    $pasien = Pasien::findOrFail($id);

    // Delete the pasien record
    $pasien->delete();

    // Redirect back with a success message
    return redirect()->route('pasien.index')->with('success', 'Data deleted successfully.');
  }
}
