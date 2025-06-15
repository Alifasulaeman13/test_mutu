<?php
namespace App\Http\Controllers;
use App\Models\FrekuensiPengumpulanData;
use Illuminate\Http\Request;
class FrekuensiPengumpulanDataController extends Controller
{
    public function index() {
        $data = FrekuensiPengumpulanData::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.frekuensi_pengumpulan_data.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.frekuensi_pengumpulan_data.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        FrekuensiPengumpulanData::create($request->only('nama'));
        return redirect()->route('frekuensi_pengumpulan_data.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $frekuensi = FrekuensiPengumpulanData::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.frekuensi_pengumpulan_data.edit', compact('frekuensi'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $frekuensi = FrekuensiPengumpulanData::findOrFail($id);
        $frekuensi->update($request->only('nama'));
        return redirect()->route('frekuensi_pengumpulan_data.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $frekuensi = FrekuensiPengumpulanData::findOrFail($id);
        $frekuensi->delete();
        return redirect()->route('frekuensi_pengumpulan_data.index')->with('success', 'Data berhasil dihapus');
    }
} 