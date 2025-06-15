<?php
namespace App\Http\Controllers;
use App\Models\DimensiMutu;
use Illuminate\Http\Request;
class DimensiMutuController extends Controller
{
    public function index() {
        $data = DimensiMutu::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.dimensi_mutu.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.dimensi_mutu.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        DimensiMutu::create($request->only('nama'));
        return redirect()->route('dimensi_mutu.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $dimensi = DimensiMutu::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.dimensi_mutu.edit', compact('dimensi'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $dimensi = DimensiMutu::findOrFail($id);
        $dimensi->update($request->only('nama'));
        return redirect()->route('dimensi_mutu.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $dimensi = DimensiMutu::findOrFail($id);
        $dimensi->delete();
        return redirect()->route('dimensi_mutu.index')->with('success', 'Data berhasil dihapus');
    }
} 