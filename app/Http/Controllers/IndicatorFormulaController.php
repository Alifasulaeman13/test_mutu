<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\IndicatorFormula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndicatorFormulaController extends Controller
{
    public function index(Request $request)
    {
        $query = IndicatorFormula::with('indicator');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('numerator_label', 'like', "%{$search}%")
                  ->orWhere('denominator_label', 'like', "%{$search}%")
                  ->orWhereHas('indicator', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $formulas = $query->orderBy('created_at', 'desc')
                         ->paginate($request->get('per_page', 10))
                         ->withQueryString();

        return view('pages.master-indikator.formula.formula', compact('formulas'));
    }

    public function create()
    {
        $indicators = Indicator::where('is_active', true)->orderBy('name')->get();
        return view('pages.master-indikator.formula.formula-add', compact('indicators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'name' => 'required|string|max:255',
            'numerator_label' => 'required|string|max:255',
            'numerator_type' => 'required|in:count,sum,boolean',
            'denominator_label' => 'required|string|max:255',
            'denominator_type' => 'required|in:count,sum,boolean',
            'calculation_type' => 'required|in:percentage,ratio,average',
            'multiplier' => 'required|numeric|between:0,100',
            'is_active' => 'boolean'
        ], [
            'indicator_id.required' => 'Indikator harus dipilih',
            'indicator_id.exists' => 'Indikator tidak valid',
            'name.required' => 'Nama formula harus diisi',
            'name.max' => 'Nama formula maksimal 255 karakter',
            'numerator_label.required' => 'Label pembilang harus diisi',
            'denominator_label.required' => 'Label penyebut harus diisi',
            'calculation_type.required' => 'Tipe perhitungan harus dipilih',
            'multiplier.required' => 'Nilai pengali harus diisi',
            'multiplier.between' => 'Nilai pengali harus antara 0 dan 100'
        ]);

        try {
            DB::beginTransaction();

            $validated['is_active'] = $request->has('is_active');

            if ($validated['is_active']) {
                IndicatorFormula::where('indicator_id', $request->indicator_id)
                    ->update(['is_active' => false]);
            }

            IndicatorFormula::create($validated);

            DB::commit();
            return redirect()
                ->route('master-indikator.formula.index')
                ->with('success', 'Formula berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan formula. ' . $e->getMessage());
        }
    }

    public function edit(IndicatorFormula $formula)
    {
        $indicators = Indicator::where('is_active', true)->orderBy('name')->get();
        return view('pages.master-indikator.formula.edit-formula', compact('formula', 'indicators'));
    }

    public function update(Request $request, IndicatorFormula $formula)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'name' => 'required|string|max:255',
            'numerator_label' => 'required|string|max:255',
            'numerator_type' => 'required|in:count,sum,boolean',
            'denominator_label' => 'required|string|max:255',
            'denominator_type' => 'required|in:count,sum,boolean',
            'calculation_type' => 'required|in:percentage,ratio,average',
            'multiplier' => 'required|numeric|between:0,100',
            'is_active' => 'boolean'
        ], [
            'indicator_id.required' => 'Indikator harus dipilih',
            'indicator_id.exists' => 'Indikator tidak valid',
            'name.required' => 'Nama formula harus diisi',
            'name.max' => 'Nama formula maksimal 255 karakter',
            'numerator_label.required' => 'Label pembilang harus diisi',
            'denominator_label.required' => 'Label penyebut harus diisi',
            'calculation_type.required' => 'Tipe perhitungan harus dipilih',
            'multiplier.required' => 'Nilai pengali harus diisi',
            'multiplier.between' => 'Nilai pengali harus antara 0 dan 100'
        ]);

        try {
            DB::beginTransaction();

            $validated['is_active'] = $request->has('is_active');

            if ($validated['is_active'] && !$formula->is_active) {
                IndicatorFormula::where('indicator_id', $request->indicator_id)
                    ->where('id', '!=', $formula->id)
                    ->update(['is_active' => false]);
            }

            $formula->update($validated);

            DB::commit();
            return redirect()
                ->route('master-indikator.formula.index')
                ->with('success', 'Formula berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui formula. ' . $e->getMessage());
        }
    }

    public function destroy(IndicatorFormula $formula)
    {
        try {
            DB::beginTransaction();
            $formula->delete();
            DB::commit();

            return redirect()
                ->route('master-indikator.formula.index')
                ->with('success', 'Formula berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus formula. ' . $e->getMessage());
        }
    }
} 