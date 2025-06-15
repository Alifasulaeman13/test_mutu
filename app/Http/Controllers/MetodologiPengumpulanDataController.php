<?php
namespace App\Http\Controllers;
use App\Models\MetodologiPengumpulanData;
use Illuminate\Http\Request;
class MetodologiPengumpulanDataController extends Controller
{
    public function index() {
        $data = MetodologiPengumpulanData::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.metodologi_pengumpulan_data.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.metodologi_pengumpulan_data.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        MetodologiPengumpulanData::create($request->only('nama'));
        return redirect()->route('metodologi_pengumpulan_data.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $metodologi = MetodologiPengumpulanData::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.metodologi_pengumpulan_data.edit', compact('metodologi'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $metodologi = MetodologiPengumpulanData::findOrFail($id);
        $metodologi->update($request->only('nama'));
        return redirect()->route('metodologi_pengumpulan_data.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $metodologi = MetodologiPengumpulanData::findOrFail($id);
        $metodologi->delete();
        return redirect()->route('metodologi_pengumpulan_data.index')->with('success', 'Data berhasil dihapus');
    }
} 