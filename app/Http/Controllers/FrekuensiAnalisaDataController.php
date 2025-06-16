<?php
namespace App\Http\Controllers;
use App\Models\FrekuensiAnalisaData;
use Illuminate\Http\Request;
class FrekuensiAnalisaDataController extends Controller
{
    public function index() {
        $data = FrekuensiAnalisaData::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.frekuensi_analisa_data.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.frekuensi_analisa_data.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        FrekuensiAnalisaData::create($request->only('nama'));
        return redirect()->route('frekuensi_analisa_data.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $frekuensi = FrekuensiAnalisaData::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.frekuensi_analisa_data.edit', compact('frekuensi'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $frekuensi = FrekuensiAnalisaData::findOrFail($id);
        $frekuensi->update($request->only('nama'));
        return redirect()->route('frekuensi_analisa_data.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $frekuensi = FrekuensiAnalisaData::findOrFail($id);
        $frekuensi->delete();
        return redirect()->route('frekuensi_analisa_data.index')->with('success', 'Data berhasil dihapus');
    }
} 