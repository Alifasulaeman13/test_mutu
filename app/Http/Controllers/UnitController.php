<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $units = Unit::orderBy('name')->paginate($perPage);
        return view('master_units.index', compact('units'));
    }

    public function create()
    {
        // Get the last unit code
        $lastUnit = Unit::orderBy('code', 'desc')->first();
        $lastCode = $lastUnit ? (int)substr($lastUnit->code, 3) : 0;
        $nextCode = 'UNT' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);
        
        return view('master_units.create', compact('nextCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:units',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($validated) {
            Unit::create($validated);
        });

        return redirect()->route('master.units.index')
            ->with('success', 'Unit berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('master_units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:255', Rule::unique('units')->ignore($unit->id)],
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($unit, $validated) {
            $unit->update($validated);
        });

        return redirect()->route('master.units.index')
            ->with('success', 'Unit berhasil diperbarui');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->users()->exists()) {
            return redirect()->route('master.units.index')
                ->with('error', 'Unit tidak dapat dihapus karena masih digunakan oleh pengguna');
        }

        DB::transaction(function () use ($unit) {
            $unit->delete();
        });

        return redirect()->route('master.units.index')
            ->with('success', 'Unit berhasil dihapus');
    }
} 