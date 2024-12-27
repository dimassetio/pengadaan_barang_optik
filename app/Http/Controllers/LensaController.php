<?php

namespace App\Http\Controllers;

use App\Models\Lensa;
use Illuminate\Http\Request;

class LensaController extends Controller
{
  public function index()
  {
    $lensas = Lensa::orderBy('created_at', 'desc')->get();
    return view('lensa.index', compact('lensas'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'merk' => 'required|string|max:255',
      'jenis' => 'required|string|max:255',
      'ukuran' => 'required|string|max:255',
      'quantity' => 'required|integer',
      'tanggal_masuk' => 'required|date',
      'penerima' => 'required|string|max:255',
    ]);

    Lensa::create($request->all());

    return redirect()->route('lensa.index')->with('success', 'Data added successfully.');
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'merk' => 'required|string|max:255',
      'jenis' => 'required|string|max:255',
      'ukuran' => 'required|string|max:255',
      'quantity' => 'required|integer',
      'tanggal_masuk' => 'required|date',
      'penerima' => 'required|string|max:255',
    ]);

    // Find the lens by ID
    $lens = Lensa::findOrFail($id);

    // Update the lens with the request data
    $lens->update($request->all());

    // Redirect back to the index page with a success message
    return redirect()->route('lensa.index')->with('success', 'Data updated successfully.');
  }

  public function destroy($id)
  {
    // Find the lens by ID
    $lens = Lensa::findOrFail($id);

    // Delete the lens record
    $lens->delete();

    // Redirect back with a success message
    return redirect()->route('lensa.index')->with('success', 'Data deleted successfully.');
  }
}
