@extends('layouts.app')

@section('title', 'Manajemen Hak Akses')

@section('content')
<div class="content-card">
    <div class="card-header flex justify-between items-center">
        <div>
            <h2 class="card-title text-2xl font-bold text-gray-800">Manajemen Hak Akses</h2>
            <p class="text-sm text-gray-600 mt-1">Atur hak akses menu untuk setiap role</p>
        </div>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-line text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="ri-error-warning-line text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('manage-akses.store') }}" method="POST" class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            @csrf
            <div class="mb-6">
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Role</label>
                <div class="relative">
                    <select name="role_id" id="role" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-lg">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="ri-arrow-down-s-line text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Menu Utama -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="ri-dashboard-line mr-2 text-primary-600"></i>
                        Menu Utama
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="dashboard" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Dashboard</span>
                        </label>
                    </div>
                </div>

                <!-- Manajemen Data Mutu -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="ri-database-2-line mr-2 text-primary-600"></i>
                        Manajemen Data Mutu
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="master_indikator" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Master Indikator</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="formula" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Formula</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="laporan_analisis" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Laporan dan Analisis</span>
                        </label>
                    </div>
                </div>

                <!-- Pengaturan -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="ri-settings-3-line mr-2 text-primary-600"></i>
                        Pengaturan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="database" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Database</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="unit" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Unit</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="manajemen_user" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Manajemen User</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="manage_role" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Manage Role</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="manajemen_unit" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Manajemen Unit</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="menu_access[]" value="hak_akses" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">Hak Akses</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="ri-save-line mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const menuAccess = @json($menuAccess);
        
        function updateCheckboxes() {
            const selectedRoleId = roleSelect.value;
            const selectedRole = @json($roles->pluck('slug', 'id'));
            const isAdmin = selectedRole[selectedRoleId] === 'admin';
            
            checkboxes.forEach(checkbox => {
                if (isAdmin) {
                    checkbox.checked = true;
                    checkbox.disabled = true;
                } else {
                    checkbox.disabled = false;
                    const menuKey = checkbox.value;
                    const hasAccess = menuAccess[selectedRoleId]?.some(access => access.menu_key === menuKey);
                    checkbox.checked = hasAccess || false;
                }
            });
        }
        
        roleSelect.addEventListener('change', updateCheckboxes);
        updateCheckboxes();
    });
</script>
@endpush

<style>
    .form-checkbox:checked {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
    
    .form-checkbox:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 2px rgba(0, 119, 116, 0.2) !important;
    }
    
    .form-checkbox:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

@endsection 