<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IndicatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Indicator::with('unit');

        // Handle search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('unit', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Handle per page
        $perPage = $request->get('per_page', 10);
        
        // Add sorting
        $query->orderBy('created_at', 'desc');

        $indicators = $query->paginate($perPage)->withQueryString();
        
        // Format data untuk table-paginate
        $formattedData = $indicators->map(function($item, $index) use ($indicators) {
            return [
                'no' => $indicators->firstItem() + $index,
                'nama' => $item->name,
                'unit' => $item->unit->name ?? '-',
                'target' => $item->target_percentage . '%',
                'tipe' => '<span class="badge ' . ($item->type == 'nasional' ? 'badge-primary' : 'badge-secondary') . '">' . ucfirst($item->type) . '</span>',
                'status' => '<span class="badge ' . ($item->is_active ? 'badge-success' : 'badge-danger') . '">' . ($item->is_active ? 'Aktif' : 'Tidak Aktif') . '</span>',
                'aksi' => view('components.action-buttons', [
                    'editUrl' => route('master-indikator.edit', $item->id),
                    'deleteUrl' => route('master-indikator.destroy', $item->id)
                ])->render()
            ];
        })->all();

        return view('pages.master-indikator.indikator.index', [
            'indicators' => $indicators,
            'data' => $formattedData
        ]);
    }

    public function create()
    {
        $units = Unit::orderBy('name')->get();
        return view('pages.master-indikator.indikator.add', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('indicators')->where(function ($query) use ($request) {
                    return $query->where('unit_id', $request->unit_id);
                })
            ],
            'target_percentage' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:nasional,lokal',
            'is_active' => 'boolean'
        ], [
            'name.unique' => 'Indikator dengan nama ini sudah ada untuk unit yang dipilih.',
            'unit_id.required' => 'Unit harus dipilih.',
            'unit_id.exists' => 'Unit yang dipilih tidak valid.',
            'target_percentage.required' => 'Target persentase harus diisi.',
            'target_percentage.numeric' => 'Target persentase harus berupa angka.',
            'target_percentage.min' => 'Target persentase minimal 0.',
            'target_percentage.max' => 'Target persentase maksimal 100.',
            'type.required' => 'Tipe indikator harus dipilih.',
            'type.in' => 'Tipe indikator tidak valid.'
        ]);

        try {
            DB::beginTransaction();

            // Set is_active default value if not provided
            $validated['is_active'] = $request->has('is_active') ? true : false;

            $indicator = Indicator::create($validated);

            DB::commit();

            return redirect()
                ->route('master-indikator.index')
                ->with('success', 'Indikator berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan indikator. ' . $e->getMessage());
        }
    }

    public function edit(Indicator $indicator)
    {
        $units = Unit::orderBy('name')->get();
        return view('pages.master-indikator.indikator.edit', compact('indicator', 'units'));
    }

    public function update(Request $request, Indicator $indicator)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('indicators')->where(function ($query) use ($request) {
                    return $query->where('unit_id', $request->unit_id);
                })->ignore($indicator->id)
            ],
            'target_percentage' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:nasional,lokal',
            'is_active' => 'boolean'
        ], [
            'name.unique' => 'Indikator dengan nama ini sudah ada untuk unit yang dipilih.',
            'unit_id.required' => 'Unit harus dipilih.',
            'unit_id.exists' => 'Unit yang dipilih tidak valid.',
            'target_percentage.required' => 'Target persentase harus diisi.',
            'target_percentage.numeric' => 'Target persentase harus berupa angka.',
            'target_percentage.min' => 'Target persentase minimal 0.',
            'target_percentage.max' => 'Target persentase maksimal 100.',
            'type.required' => 'Tipe indikator harus dipilih.',
            'type.in' => 'Tipe indikator tidak valid.'
        ]);

        try {
            DB::beginTransaction();

            // Set is_active value
            $validated['is_active'] = $request->has('is_active') ? true : false;

            $indicator->update($validated);

            DB::commit();

            return redirect()
                ->route('master-indikator.index')
                ->with('success', 'Indikator berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui indikator. ' . $e->getMessage());
        }
    }

    public function destroy(Indicator $indicator)
    {
        try {
            DB::beginTransaction();

            // Check if indicator has related data
            if ($indicator->dailyData()->exists()) {
                throw new \Exception('Indikator tidak dapat dihapus karena memiliki data harian terkait.');
            }

            if ($indicator->formulas()->exists()) {
                throw new \Exception('Indikator tidak dapat dihapus karena memiliki formula terkait.');
            }

            $indicator->delete();

            DB::commit();

            return redirect()
                ->route('master-indikator.index')
                ->with('success', 'Indikator berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
} 