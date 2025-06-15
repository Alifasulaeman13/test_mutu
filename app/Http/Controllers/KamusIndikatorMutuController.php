<?php

namespace App\Http\Controllers;

use App\Models\KamusIndikatorMutu;
use App\Models\Indicator;
use App\Models\DimensiMutu;
use App\Models\MetodologiPengumpulanData;
use App\Models\CakupanData;
use App\Models\FrekuensiPengumpulanData;
use App\Models\FrekuensiAnalisaData;
use App\Models\MetodologiAnalisaData;
use App\Models\InterpretasiData;
use App\Models\PublikasiData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KamusIndikatorMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kamusIndikator = KamusIndikatorMutu::with([
            'indicator',
            'dimensiMutu',
            'metodologiPengumpulan',
            'cakupanData',
            'frekuensiPengumpulan',
            'frekuensiAnalisa',
            'metodologiAnalisa',
            'interpretasiData',
            'publikasiData'
        ])->paginate(10);

        // Mapping data agar sesuai dengan field columns table-paginate
        $data = $kamusIndikator->map(function($item, $index) use ($kamusIndikator) {
            return [
                'no' => $kamusIndikator->firstItem() + $index,
                'nama_indikator' => $item->indicator->name ?? '-',
                'dimensi_mutu' => $item->dimensiMutu->nama ?? '-',
                'metodologi_pengumpulan' => $item->metodologiPengumpulan->nama ?? '-',
                'cakupan_data' => $item->cakupanData->nama ?? '-',
                'frekuensi_pengumpulan' => $item->frekuensiPengumpulan->nama ?? '-',
                'frekuensi_analisa' => $item->frekuensiAnalisa->nama ?? '-',
                'metodologi_analisa' => $item->metodologiAnalisa->nama ?? '-',
                'interpretasi' => $item->interpretasiData->nama ?? '-',
                'publikasi' => $item->publikasiData->nama ?? '-',
                'aksi' => view('components.action-buttons', [
                    'editUrl' => route('kamus-indikator.edit', $item->id),
                    'deleteUrl' => route('kamus-indikator.destroy', $item->id)
                ])->render(),
            ];
        });

        // Logging untuk debugging
        Log::info('Get Kamus Indikator Mutu', [
            'total' => $kamusIndikator->total(),
            'count' => $kamusIndikator->count(),
            'data_preview' => $data->take(3)->toArray(),
        ]);

        return view('pages.kamus_indikator.index', [
            'kamusIndikator' => $kamusIndikator,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $indicators = Indicator::all();
        $dimensiMutu = DimensiMutu::all();
        $metodologiPengumpulan = MetodologiPengumpulanData::all();
        $cakupanData = CakupanData::all();
        $frekuensiPengumpulan = FrekuensiPengumpulanData::all();
        $frekuensiAnalisa = FrekuensiAnalisaData::all();
        $metodologiAnalisa = MetodologiAnalisaData::all();
        $interpretasiData = InterpretasiData::all();
        $publikasiData = PublikasiData::all();

        return view('pages.kamus_indikator.add', compact(
            'indicators',
            'dimensiMutu',
            'metodologiPengumpulan',
            'cakupanData',
            'frekuensiPengumpulan',
            'frekuensiAnalisa',
            'metodologiAnalisa',
            'interpretasiData',
            'publikasiData'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'indikator_id' => 'required|exists:indicators,id',
            'definisi_operasional' => 'required|string',
            'tujuan' => 'required|string',
            'dimensi_mutu_id' => 'required|exists:dimensi_mutu,id',
            'dasar_pemikiran' => 'required|string',
            'formula_pengukuran' => 'required|string',
            'metodologi_pengumpulan_data' => 'required|string',
            'metodologi_pengumpulan_data_id' => 'required|exists:metodologi_pengumpulan_data,id',
            'cakupan_data_id' => 'required|exists:cakupan_data,id',
            'pengumpulan_data' => 'required|string',
            'frekuensi_pengumpulan_data_id' => 'required|exists:frekuensi_pengumpulan_data,id',
            'frekuensi_analisa_data_id' => 'required|exists:frekuensi_analisa_data,id',
            'metodologi_analisa_data_id' => 'required|exists:metodologi_analisa_data,id',
            'interpretasi_data_id' => 'required|exists:interpretasi_data,id',
            'sumber_data' => 'required|string',
            'penanggung_jawab_pengumpul_data' => 'required|string',
            'publikasi_data_id' => 'required|exists:publikasi_data,id',
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah indikator sudah memiliki kamus
            $existingKamus = KamusIndikatorMutu::where('indikator_id', $validated['indikator_id'])->first();
            if ($existingKamus) {
                throw new \Exception('Indikator ini sudah memiliki kamus indikator mutu.');
            }

            KamusIndikatorMutu::create($validated);

            DB::commit();
            return redirect()->route('kamus-indikator.index')
                ->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KamusIndikatorMutu $kamusIndikator)
    {
        $indicators = Indicator::whereDoesntHave('kamusIndikator')
            ->orWhere('id', $kamusIndikator->indikator_id)
            ->get();
        $dimensiMutu = DimensiMutu::all();
        $metodologiPengumpulan = MetodologiPengumpulanData::all();
        $cakupanData = CakupanData::all();
        $frekuensiPengumpulan = FrekuensiPengumpulanData::all();
        $frekuensiAnalisa = FrekuensiAnalisaData::all();
        $metodologiAnalisa = MetodologiAnalisaData::all();
        $interpretasiData = InterpretasiData::all();
        $publikasiData = PublikasiData::all();

        return view('pages.kamus_indikator.edit', compact(
            'kamusIndikator',
            'indicators',
            'dimensiMutu',
            'metodologiPengumpulan',
            'cakupanData',
            'frekuensiPengumpulan',
            'frekuensiAnalisa',
            'metodologiAnalisa',
            'interpretasiData',
            'publikasiData'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KamusIndikatorMutu $kamusIndikator)
    {
        $validated = $request->validate([
            'indikator_id' => 'required|exists:indicators,id',
            'definisi_operasional' => 'required|string',
            'tujuan' => 'required|string',
            'dimensi_mutu_id' => 'required|exists:dimensi_mutu,id',
            'dasar_pemikiran' => 'required|string',
            'formula_pengukuran' => 'required|string',
            'metodologi_pengumpulan_data' => 'required|string',
            'metodologi_pengumpulan_data_id' => 'required|exists:metodologi_pengumpulan_data,id',
            'cakupan_data_id' => 'required|exists:cakupan_data,id',
            'pengumpulan_data' => 'required|string',
            'frekuensi_pengumpulan_data_id' => 'required|exists:frekuensi_pengumpulan_data,id',
            'frekuensi_analisa_data_id' => 'required|exists:frekuensi_analisa_data,id',
            'metodologi_analisa_data_id' => 'required|exists:metodologi_analisa_data,id',
            'interpretasi_data_id' => 'required|exists:interpretasi_data,id',
            'sumber_data' => 'required|string',
            'penanggung_jawab_pengumpul_data' => 'required|string',
            'publikasi_data_id' => 'required|exists:publikasi_data,id',
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah indikator sudah memiliki kamus lain
            if ($validated['indikator_id'] != $kamusIndikator->indikator_id) {
                $existingKamus = KamusIndikatorMutu::where('indikator_id', $validated['indikator_id'])
                    ->where('id', '!=', $kamusIndikator->id)
                    ->first();
                if ($existingKamus) {
                    throw new \Exception('Indikator ini sudah memiliki kamus indikator mutu.');
                }
            }

            $kamusIndikator->update($validated);

            DB::commit();
            return redirect()->route('kamus-indikator.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KamusIndikatorMutu $kamusIndikator)
    {
        try {
            DB::beginTransaction();
            $kamusIndikator->delete();
            DB::commit();
            return redirect()->route('kamus-indikator.index')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
