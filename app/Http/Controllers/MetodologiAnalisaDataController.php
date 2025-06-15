<?php
namespace App\Http\Controllers;
use App\Models\MetodologiAnalisaData;
use Illuminate\Http\Request;
class MetodologiAnalisaDataController extends Controller
{
    public function index() {
        $data = MetodologiAnalisaData::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.metodologi_analisa_data.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.metodologi_analisa_data.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        MetodologiAnalisaData::create($request->only('nama'));
        return redirect()->route('metodologi_analisa_data.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $metodologi = MetodologiAnalisaData::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.metodologi_analisa_data.edit', compact('metodologi'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $metodologi = MetodologiAnalisaData::findOrFail($id);
        $metodologi->update($request->only('nama'));
        return redirect()->route('metodologi_analisa_data.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $metodologi = MetodologiAnalisaData::findOrFail($id);
        $metodologi->delete();
        return redirect()->route('metodologi_analisa_data.index')->with('success', 'Data berhasil dihapus');
    }
} 