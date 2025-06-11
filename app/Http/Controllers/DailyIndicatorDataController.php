<?php

namespace App\Http\Controllers;

use App\Models\DailyIndicatorData;
use App\Models\Indicator;
use Illuminate\Http\Request;

class DailyIndicatorDataController extends Controller
{
    public function index()
    {
        $dailyData = DailyIndicatorData::with('indicator.unit')
            ->orderBy('date', 'desc')
            ->get();
        return view('pages.laporan&analisis.index', compact('dailyData'));
    }

    public function create()
    {
        $indicators = Indicator::with(['activeFormula', 'unit'])->get();
        return view('pages.laporan&analisis.create', compact('indicators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'date' => 'required|date',
            'numerator' => 'required|integer|min:0',
            'denominator' => 'required|integer|min:1',
        ]);

        $indicator = Indicator::find($request->indicator_id);
        $formula = $indicator->activeFormula();

        if ($formula) {
            $achievement = $formula->calculateResult($request->numerator, $request->denominator);
        } else {
            $achievement = ($request->numerator / $request->denominator) * 100;
        }

        $validated['achievement_percentage'] = $achievement;

        // Check for duplicate entry
        $exists = DailyIndicatorData::where('indicator_id', $request->indicator_id)
            ->where('date', $request->date)
            ->exists();

        if ($exists) {
            return back()->withErrors(['date' => 'Data untuk tanggal ini sudah ada'])
                ->withInput();
        }

        DailyIndicatorData::create($validated);

        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Data harian berhasil ditambahkan');
    }

    public function edit(DailyIndicatorData $dailyData)
    {
        $indicators = Indicator::with(['activeFormula', 'unit'])->get();
        return view('pages.laporan&analisis.edit', compact('dailyData', 'indicators'));
    }

    public function update(Request $request, DailyIndicatorData $dailyData)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'date' => 'required|date',
            'numerator' => 'required|integer|min:0',
            'denominator' => 'required|integer|min:1',
        ]);

        $indicator = Indicator::find($request->indicator_id);
        $formula = $indicator->activeFormula();

        if ($formula) {
            $achievement = $formula->calculateResult($request->numerator, $request->denominator);
        } else {
            $achievement = ($request->numerator / $request->denominator) * 100;
        }

        $validated['achievement_percentage'] = $achievement;

        // Check for duplicate entry, excluding current record
        $exists = DailyIndicatorData::where('indicator_id', $request->indicator_id)
            ->where('date', $request->date)
            ->where('id', '!=', $dailyData->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['date' => 'Data untuk tanggal ini sudah ada'])
                ->withInput();
        }

        $dailyData->update($validated);

        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Data harian berhasil diperbarui');
    }

    public function destroy(DailyIndicatorData $dailyData)
    {
        $dailyData->delete();
        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Data harian berhasil dihapus');
    }
} 