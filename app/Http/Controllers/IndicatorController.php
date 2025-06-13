<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

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
                'periode' => $item->is_period_active ? 
                    "{$item->reporting_start_day} - {$item->reporting_end_day}" : 
                    '<span class="badge badge-warning">Tidak Aktif</span>',
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
        try {
            Log::info('Attempting to store new indicator', [
                'request_data' => $request->all()
            ]);

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
                'is_active' => 'nullable',
                'reporting_start_day' => 'required|integer|min:1|max:31',
                'reporting_end_day' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:31',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value < $request->reporting_start_day) {
                            $fail('Tanggal selesai pelaporan harus lebih besar atau sama dengan tanggal mulai.');
                        }
                    }
                ],
                'is_period_active' => 'nullable'
            ], [
                'name.unique' => 'Indikator dengan nama ini sudah ada untuk unit yang dipilih.',
                'unit_id.required' => 'Unit harus dipilih.',
                'unit_id.exists' => 'Unit yang dipilih tidak valid.',
                'target_percentage.required' => 'Target persentase harus diisi.',
                'target_percentage.numeric' => 'Target persentase harus berupa angka.',
                'target_percentage.min' => 'Target persentase minimal 0.',
                'target_percentage.max' => 'Target persentase maksimal 100.',
                'type.required' => 'Tipe indikator harus dipilih.',
                'type.in' => 'Tipe indikator tidak valid.',
                'reporting_start_day.required' => 'Tanggal mulai pelaporan harus diisi.',
                'reporting_start_day.integer' => 'Tanggal mulai pelaporan harus berupa angka.',
                'reporting_start_day.min' => 'Tanggal mulai pelaporan minimal 1.',
                'reporting_start_day.max' => 'Tanggal mulai pelaporan maksimal 31.',
                'reporting_end_day.required' => 'Tanggal selesai pelaporan harus diisi.',
                'reporting_end_day.integer' => 'Tanggal selesai pelaporan harus berupa angka.',
                'reporting_end_day.min' => 'Tanggal selesai pelaporan minimal 1.',
                'reporting_end_day.max' => 'Tanggal selesai pelaporan maksimal 31.'
            ]);

            DB::beginTransaction();

            // Convert checkbox values to boolean
            $validated['is_active'] = $request->has('is_active');
            $validated['is_period_active'] = $request->has('is_period_active');

            $indicator = Indicator::create($validated);

            DB::commit();

            Log::info('Successfully created new indicator', [
                'indicator_id' => $indicator->id,
                'indicator_data' => $indicator->toArray()
            ]);

            return redirect()
                ->route('master-indikator.index')
                ->with('success', 'Indikator berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create indicator', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

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
        try {
            Log::info('Attempting to update indicator', [
                'indicator_id' => $indicator->id,
                'request_data' => $request->all()
            ]);

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
                'is_active' => 'nullable',
                'reporting_start_day' => 'required|integer|min:1|max:31',
                'reporting_end_day' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:31',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value < $request->reporting_start_day) {
                            $fail('Tanggal selesai pelaporan harus lebih besar atau sama dengan tanggal mulai.');
                        }
                    }
                ],
                'is_period_active' => 'nullable'
            ], [
                'name.unique' => 'Indikator dengan nama ini sudah ada untuk unit yang dipilih.',
                'unit_id.required' => 'Unit harus dipilih.',
                'unit_id.exists' => 'Unit yang dipilih tidak valid.',
                'target_percentage.required' => 'Target persentase harus diisi.',
                'target_percentage.numeric' => 'Target persentase harus berupa angka.',
                'target_percentage.min' => 'Target persentase minimal 0.',
                'target_percentage.max' => 'Target persentase maksimal 100.',
                'type.required' => 'Tipe indikator harus dipilih.',
                'type.in' => 'Tipe indikator tidak valid.',
                'reporting_start_day.required' => 'Tanggal mulai pelaporan harus diisi.',
                'reporting_start_day.integer' => 'Tanggal mulai pelaporan harus berupa angka.',
                'reporting_start_day.min' => 'Tanggal mulai pelaporan minimal 1.',
                'reporting_start_day.max' => 'Tanggal mulai pelaporan maksimal 31.',
                'reporting_end_day.required' => 'Tanggal selesai pelaporan harus diisi.',
                'reporting_end_day.integer' => 'Tanggal selesai pelaporan harus berupa angka.',
                'reporting_end_day.min' => 'Tanggal selesai pelaporan minimal 1.',
                'reporting_end_day.max' => 'Tanggal selesai pelaporan maksimal 31.'
            ]);

            DB::beginTransaction();

            // Convert checkbox values to boolean
            $validated['is_active'] = $request->has('is_active');
            $validated['is_period_active'] = $request->has('is_period_active');

            $indicator->update($validated);

            DB::commit();

            Log::info('Successfully updated indicator', [
                'indicator_id' => $indicator->id,
                'updated_data' => $indicator->toArray()
            ]);

            return redirect()
                ->route('master-indikator.index')
                ->with('success', 'Indikator berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to update indicator', [
                'indicator_id' => $indicator->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

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
            if ($indicator->monthlyData()->exists()) {
                throw new \Exception('Indikator tidak dapat dihapus karena memiliki data bulanan terkait.');
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