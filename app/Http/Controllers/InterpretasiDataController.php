<?php
namespace App\Http\Controllers;
use App\Models\InterpretasiData;
use Illuminate\Http\Request;
class InterpretasiDataController extends Controller
{
    public function index() {
        $data = InterpretasiData::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.interpretasi_data.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.interpretasi_data.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        InterpretasiData::create($request->only('nama'));
        return redirect()->route('interpretasi_data.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $interpretasi = InterpretasiData::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.interpretasi_data.edit', compact('interpretasi'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $interpretasi = InterpretasiData::findOrFail($id);
        $interpretasi->update($request->only('nama'));
        return redirect()->route('interpretasi_data.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $interpretasi = InterpretasiData::findOrFail($id);
        $interpretasi->delete();
        return redirect()->route('interpretasi_data.index')->with('success', 'Data berhasil dihapus');
    }
} 