<?php

namespace App\Http\Controllers;

use App\Models\MonthlyIndicatorData;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonthlyIndicatorDataController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->get('bulan', date('n'));
        $currentYear = $request->get('tahun', date('Y'));

        // Cek apakah user adalah Administrator
        $isAdmin = auth()->user()->isAdmin();

        // Base query untuk indikator
        $query = Indicator::with(['unit', 'activeFormula'])
            ->where('is_active', true);

        // Filter berdasarkan unit jika bukan admin
        if (!$isAdmin && auth()->user()->unit) {
            $query->where('unit_id', auth()->user()->unit->id);
        }

        // Ambil semua indikator
        $indicators = $query->get();

        // Ambil data bulanan untuk periode yang dipilih
        $monthlyData = MonthlyIndicatorData::with('indicator.unit')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get()
            ->keyBy('indicator_id');

        // Siapkan data untuk view
        $displayData = $indicators->map(function ($indicator) use ($monthlyData, $currentMonth, $currentYear) {
            $data = $monthlyData->get($indicator->id);
            
            // Buat objek Carbon untuk tanggal 1 di bulan dan tahun yang dipilih
            $date = Carbon::createFromDate($currentYear, $currentMonth, 1);
            
            return [
                'id' => $indicator->id,
                'indikator' => $indicator->name,
                'unit' => $indicator->unit->name,
                'target' => $indicator->target_percentage . '%',
                'numerator' => $data ? $data->numerator : null,
                'denominator' => $data ? $data->denominator : null,
                'total' => $data ? $data->achievement_percentage : null,
                'periode' => [
                    'bulan' => $date->format('F'),
                    'tahun' => $currentYear
                ],
                'status_periode' => $indicator->isWithinReportingPeriod() ? 'Aktif' : 'Tidak Aktif',
                'data_id' => $data ? $data->id : null,
                'has_data' => $data ? true : false
            ];
        })->values();

        return view('pages.laporan&analisis.index', compact('displayData', 'currentMonth', 'currentYear', 'isAdmin'));
    }

    public function create(Request $request)
    {
        // Base query
        $query = Indicator::with(['activeFormula', 'unit']);

        // Cek apakah user adalah Administrator
        $isAdmin = auth()->user()->isAdmin();

        // Jika bukan admin dan memiliki unit, filter berdasarkan unit tersebut
        if (!$isAdmin && auth()->user()->unit) {
            $query->where('unit_id', auth()->user()->unit->id);
        }

        // Ambil semua indikator yang aktif
        $indicators = $query->where('is_active', true)->get();

        // Filter indikator berdasarkan periode pelaporan jika bukan admin
        if (!$isAdmin) {
            $indicators = $indicators->filter(function($indicator) {
                return $indicator->isWithinReportingPeriod();
            });
        }

        if ($indicators->isEmpty()) {
            return redirect()->route('laporan-analisis.index')
                ->with('error', 'Tidak ada indikator yang dapat diisi pada periode ini');
        }

        // Kelompokkan indikator berdasarkan unit untuk admin
        $groupedIndicators = $isAdmin ? $indicators->groupBy('unit.name') : null;

        // Pre-selected indicator dari query parameter
        $selectedIndicatorId = $request->query('indicator_id');

        return view('pages.laporan&analisis.create', compact('indicators', 'groupedIndicators', 'isAdmin', 'selectedIndicatorId'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        // Get the indicator
        $indicator = Indicator::findOrFail($validated['indicator_id']);

        // Check if user has access to this indicator
        // Skip unit check if user is admin
        if (!auth()->user()->isAdmin() && auth()->user()->unit) {
            if ($indicator->unit_id !== auth()->user()->unit->id) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak memiliki akses untuk menambahkan data indikator ini'
                    ], 403);
                }
                return redirect()->route('laporan-analisis.index')
                    ->with('error', 'Anda tidak memiliki akses untuk menambahkan data indikator ini');
            }
        }

        // Check if within reporting period
        if (!$indicator->isWithinReportingPeriod()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Periode pengisian data sudah berakhir'
                ], 403);
            }
            return redirect()->route('laporan-analisis.index')
                ->with('error', 'Periode pengisian data sudah berakhir');
        }

        // Create date from month and year
        $date = Carbon::createFromDate($validated['year'], $validated['month'], 1);

        // Calculate achievement percentage
        $achievement = ($validated['numerator'] / $validated['denominator']) * 100;

        // Check if data already exists for this month
        $exists = MonthlyIndicatorData::where('indicator_id', $validated['indicator_id'])
            ->whereYear('date', $validated['year'])
            ->whereMonth('date', $validated['month'])
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data untuk bulan ini sudah ada'
                ], 422);
            }
            return back()->withErrors(['month' => 'Data untuk bulan ini sudah ada'])
                ->withInput();
        }

        // Create data array
        $data = [
            'indicator_id' => $validated['indicator_id'],
            'numerator' => $validated['numerator'],
            'denominator' => $validated['denominator'],
            'date' => $date,
            'achievement_percentage' => $achievement
        ];

        // Create the record
        MonthlyIndicatorData::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data bulanan berhasil ditambahkan'
            ]);
        }

        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Data bulanan berhasil ditambahkan');
    }

    public function edit(MonthlyIndicatorData $monthlyData)
    {
        // Cek akses user ke indikator
        if (auth()->user()->unit) {
            if ($monthlyData->indicator->unit_id !== auth()->user()->unit->id) {
                return redirect()->route('laporan-analisis.index')
                    ->with('error', 'Anda tidak memiliki akses ke data ini');
            }
        }

        // Cek periode pengisian
        if (!$monthlyData->indicator->isWithinReportingPeriod()) {
            return redirect()->route('laporan-analisis.index')
                ->with('error', 'Periode pengisian data sudah berakhir');
        }

        $indicators = Indicator::with(['activeFormula', 'unit'])->get();
        return view('pages.laporan&analisis.edit', compact('monthlyData', 'indicators'));
    }

    public function update(Request $request, MonthlyIndicatorData $monthlyData)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
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
            return back()->withErrors(['month' => 'Periode pengisian data sudah berakhir'])
                ->withInput();
        }

        $formula = $indicator->activeFormula;

        if ($formula) {
            $achievement = $formula->calculateResult($request->numerator, $request->denominator);
        } else {
            $achievement = ($request->numerator / $request->denominator) * 100;
        }

        // Set tanggal ke hari pertama bulan yang dipilih
        $date = Carbon::createFromDate($request->year, $request->month, 1);
        
        $validated['date'] = $date;
        $validated['achievement_percentage'] = $achievement;

        // Cek duplikasi data, kecuali data saat ini
        $exists = MonthlyIndicatorData::where('indicator_id', $request->indicator_id)
            ->whereYear('date', $request->year)
            ->whereMonth('date', $request->month)
            ->where('id', '!=', $monthlyData->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['month' => 'Data untuk bulan ini sudah ada'])
                ->withInput();
        }

        $monthlyData->update($validated);

        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Data bulanan berhasil diperbarui');
    }

    public function destroy(MonthlyIndicatorData $monthlyData)
    {
        // Cek akses user ke indikator
        if (auth()->user()->unit) {
            if ($monthlyData->indicator->unit_id !== auth()->user()->unit->id) {
                return redirect()->route('laporan-analisis.index')
                    ->with('error', 'Anda tidak memiliki akses untuk menghapus data ini');
            }
        }

        // Cek periode pengisian
        if (!$monthlyData->indicator->isWithinReportingPeriod()) {
            return redirect()->route('laporan-analisis.index')
                ->with('error', 'Periode pengisian data sudah berakhir');
        }

        $monthlyData->delete();
        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Data bulanan berhasil dihapus');
    }
} 