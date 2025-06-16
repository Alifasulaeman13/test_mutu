<?php
namespace App\Http\Controllers;
use App\Models\CakupanData;
use Illuminate\Http\Request;
class CakupanDataController extends Controller
{
    public function index() {
        $data = CakupanData::paginate(10);
        return view('pages.kamus_indikator.master_kamus_indikator.cakupan_data.index', compact('data'));
    }
    public function create() {
        return view('pages.kamus_indikator.master_kamus_indikator.cakupan_data.add');
    }
    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255']);
        CakupanData::create($request->only('nama'));
        return redirect()->route('cakupan_data.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        $cakupan = CakupanData::findOrFail($id);
        return view('pages.kamus_indikator.master_kamus_indikator.cakupan_data.edit', compact('cakupan'));
    }
    public function update(Request $request, $id) {
        $request->validate(['nama' => 'required|string|max:255']);
        $cakupan = CakupanData::findOrFail($id);
        $cakupan->update($request->only('nama'));
        return redirect()->route('cakupan_data.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id) {
        $cakupan = CakupanData::findOrFail($id);
        $cakupan->delete();
        return redirect()->route('cakupan_data.index')->with('success', 'Data berhasil dihapus');
    }
} 