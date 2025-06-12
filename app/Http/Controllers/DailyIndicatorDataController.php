<?php

namespace App\Http\Controllers;

use App\Models\DailyIndicatorData;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyIndicatorDataController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->get('bulan', date('n'));
        $currentYear = $request->get('tahun', date('Y'));

        // Base query
        $query = DailyIndicatorData::with('indicator.unit')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear);

        // Cek apakah user adalah Administrator
        $isAdmin = auth()->user()->isAdmin();

        // Jika bukan admin dan memiliki unit, filter berdasarkan unit tersebut
        if (!$isAdmin && auth()->user()->unit) {
            $query->whereHas('indicator', function($q) {
                $q->where('unit_id', auth()->user()->unit->id);
            });
        }

        $dailyData = $query->get()
            ->groupBy('indicator_id')
            ->map(function ($items) {
                $firstItem = $items->first();
                $indicator = $firstItem->indicator;
                $period = $indicator->getCurrentReportingPeriod();
                
                return [
                    'indikator' => $indicator->name,
                    'unit' => $indicator->unit->name,
                    'target' => $indicator->target_percentage . '%',
                    'numerator' => $items->sum('numerator'),
                    'denominator' => $items->sum('denominator'),
                    'total' => $items->avg('achievement_percentage'),
                    'periode' => [
                        'mulai' => $period['start_date'],
                        'selesai' => $period['end_date'],
                        'bulan' => Carbon::create()->month($period['month'])->format('F'),
                        'tahun' => $period['year']
                    ],
                    'status_periode' => $indicator->isWithinReportingPeriod() ? 'Aktif' : 'Tidak Aktif'
                ];
            })
            ->values();

        return view('pages.laporan&analisis.index', compact('dailyData', 'currentMonth', 'currentYear'));
    }

    public function create()
    {
        // Base query
        $query = Indicator::with(['activeFormula', 'unit']);

        // Jika user memiliki unit, filter berdasarkan unit tersebut
        if (auth()->user()->unit) {
            $query->where('unit_id', auth()->user()->unit->id);
        }

        $indicators = $query->get()->filter(function($indicator) {
            return $indicator->isWithinReportingPeriod();
        });

        if ($indicators->isEmpty()) {
            return redirect()->route('laporan-analisis.index')
                ->with('error', 'Tidak ada indikator yang dapat diisi pada periode ini');
        }

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

        // Cek akses user ke indikator
        if (auth()->user()->unit) {
            $indicator = Indicator::where('id', $request->indicator_id)
                ->where('unit_id', auth()->user()->unit->id)
                ->first();

            if (!$indicator) {
                return back()->withErrors(['indicator_id' => 'Anda tidak memiliki akses ke indikator ini'])
                    ->withInput();
            }
        }

        $indicator = Indicator::with('activeFormula')->find($request->indicator_id);

        // Cek periode pengisian
        if (!$indicator->isWithinReportingPeriod()) {
            return back()->withErrors(['date' => 'Periode pengisian data sudah berakhir'])
                ->withInput();
        }

        $formula = $indicator->activeFormula;

        if ($formula) {
            $achievement = $formula->calculateResult($request->numerator, $request->denominator);
        } else {
            $achievement = ($request->numerator / $request->denominator) * 100;
        }

        $validated['achievement_percentage'] = $achievement;

        // Cek duplikasi data
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
        // Cek akses user ke indikator
        if (auth()->user()->unit) {
            if ($dailyData->indicator->unit_id !== auth()->user()->unit->id) {
                return redirect()->route('laporan-analisis.index')
                    ->with('error', 'Anda tidak memiliki akses ke data ini');
            }
        }

        // Cek periode pengisian
        if (!$dailyData->indicator->isWithinReportingPeriod()) {
            return redirect()->route('laporan-analisis.index')
                ->with('error', 'Periode pengisian data sudah berakhir');
        }

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

        // Cek akses user ke indikator
        if (auth()->user()->unit) {
            $indicator = Indicator::where('id', $request->indicator_id)
                ->where('unit_id', auth()->user()->unit->id)
                ->first();

            if (!$indicator) {
                return back()->withErrors(['indicator_id' => 'Anda tidak memiliki akses ke indikator ini'])
                    ->withInput();
            }
        }

        $indicator = Indicator::with('activeFormula')->find($request->indicator_id);

        // Cek periode pengisian
        if (!$indicator->isWithinReportingPeriod()) {
            return back()->withErrors(['date' => 'Periode pengisian data sudah berakhir'])
                ->withInput();
        }

        $formula = $indicator->activeFormula;

        if ($formula) {
            $achievement = $formula->calculateResult($request->numerator, $request->denominator);
        } else {
            $achievement = ($request->numerator / $request->denominator) * 100;
        }

        $validated['achievement_percentage'] = $achievement;

        // Cek duplikasi data, kecuali data saat ini
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
        // Cek akses user ke indikator
        if (auth()->user()->unit) {
            if ($dailyData->indicator->unit_id !== auth()->user()->unit->id) {
                return redirect()->route('laporan-analisis.index')
                    ->with('error', 'Anda tidak memiliki akses untuk menghapus data ini');
            }
        }

        // Cek periode pengisian
        if (!$dailyData->indicator->isWithinReportingPeriod()) {
            return redirect()->route('laporan-analisis.index')
                ->with('error', 'Periode pengisian data sudah berakhir');
        }

        $dailyData->delete();
        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Data harian berhasil dihapus');
    }
} 