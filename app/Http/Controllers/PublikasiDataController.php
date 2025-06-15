<?php
namespace App\Http\Controllers;
use App\Models\PublikasiData;
use Illuminate\Http\Request;
class PublikasiDataController extends Controller
{
    public function index() {
        $data = PublikasiData::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.publikasi_data.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.publikasi_data.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        PublikasiData::create($request->only('nama'));
        return redirect()->route('publikasi_data.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $publikasi = PublikasiData::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.publikasi_data.edit', compact('publikasi'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $publikasi = PublikasiData::findOrFail($id);
        $publikasi->update($request->only('nama'));
        return redirect()->route('publikasi_data.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $publikasi = PublikasiData::findOrFail($id);
        $publikasi->delete();
        return redirect()->route('publikasi_data.index')->with('success', 'Data berhasil dihapus');
    }
} 