<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\Request;

class FrameController extends Controller
{
  public function index()
  {
    $frames = Frame::orderBy('created_at', 'desc')->get();
    return view('frame.index', compact('frames'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'kode' => 'required|string|max:255',
      'warna' => 'required|string|max:255',
      'quantity' => 'required|integer',
      'tanggal_masuk' => 'required|date',
      'penerima' => 'required|string|max:255',
    ]);

    Frame::create($request->all());

    return redirect()->route('frame.index')->with('success', 'Data added successfully.');
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'kode' => 'required|string|max:255',
      'warna' => 'required|string|max:255',
      'quantity' => 'required|integer',
      'tanggal_masuk' => 'required|date',
      'penerima' => 'required|string|max:255',
    ]);

    // Find the frame by ID
    $frame = Frame::findOrFail($id);

    // Update the frame with the request data
    $frame->update($request->all());

    // Redirect back to the index page with a success message
    return redirect()->route('frame.index')->with('success', 'Data updated successfully.');
  }

  public function destroy($id)
  {
    // Find the frame by ID
    $frame = Frame::findOrFail($id);

    // Delete the frame record
    $frame->delete();

    // Redirect back with a success message
    return redirect()->route('frame.index')->with('success', 'Data deleted successfully.');
  }
}