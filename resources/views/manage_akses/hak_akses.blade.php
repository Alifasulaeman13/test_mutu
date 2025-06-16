@extends('layouts.app')

@section('title', 'Manajemen Hak Akses')

@section('content')
<div class="max-w-4xl mx-auto mt-6">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-primary-50 to-white">
            <h2 class="text-3xl font-extrabold text-primary-700 mb-1 flex items-center gap-2">
                <i class="ri-shield-check-line text-2xl text-primary-600"></i>
                Manajemen Hak Akses
            </h2>
            <p class="text-base text-gray-500">Atur hak akses menu untuk setiap role</p>
        </div>
        <div class="px-8 py-8">
        @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg flex items-center gap-3">
                    <i class="ri-checkbox-circle-line text-green-500 text-2xl"></i>
                    <span class="text-green-700 text-base">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg flex items-center gap-3">
                    <i class="ri-error-warning-line text-red-500 text-2xl"></i>
                    <span class="text-red-700 text-base">{{ session('error') }}</span>
            </div>
        @endif
            <form action="{{ route('manage-akses.store') }}" method="POST" class="space-y-8">
            @csrf
                <div>
                    <label for="role" class="block text-base font-semibold text-gray-700 mb-2">Pilih Role</label>
                <div class="relative">
                        <select name="role_id" id="role" class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-primary-500 rounded-xl shadow-sm bg-white">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="ri-arrow-down-s-line text-gray-400"></i>
                    </div>
                </div>
            </div>
                <div class="space-y-8">
                    @foreach(['utama' => 'Menu Utama', 'manajemen_mutu' => 'Manajemen Data Mutu', 'pengaturan' => 'Pengaturan'] as $groupKey => $groupLabel)
                        <div class="bg-primary-50/60 p-6 rounded-xl border border-primary-100 shadow-sm">
                            <h3 class="text-base font-semibold text-primary-700 mb-4 flex items-center gap-2">
                                <i class="{{ $menuList[$groupKey][0]['icon'] ?? 'ri-menu-line' }} text-primary-600"></i>
                                {{ $groupLabel }}
                    </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($menuList[$groupKey] as $menu)
                                <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:shadow-md transition cursor-pointer group text-sm font-normal">
                                    <input type="checkbox" name="menu_access[]" value="{{ $menu['key'] }}" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 transition duration-150">
                                    <span class="text-gray-800 group-hover:text-primary-600">{{ $menu['label'] }}</span>
                        </label>
                                @endforeach
                                @if($groupKey === 'manajemen_mutu')
                                    @foreach($menuList['manajemen_mutu_lain'] as $menu)
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:shadow-md transition cursor-pointer group text-sm font-normal">
                                        <input type="checkbox" name="menu_access[]" value="{{ $menu['key'] }}" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 transition duration-150">
                                        <span class="text-gray-800 group-hover:text-primary-600">{{ $menu['label'] }}</span>
                        </label>
                                    @endforeach
                                @endif
                    </div>
                </div>
                    @endforeach
                </div>
                <div class="pt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-xl shadow-lg text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 transition duration-150 ease-in-out gap-2">
                        <i class="ri-save-line text-xl text-white"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
        </div>
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
                const label = checkbox.closest('label');
                if (isAdmin) {
                    checkbox.checked = true;
                    checkbox.disabled = true;
                    label.classList.add('opacity-75');
                } else {
                    checkbox.disabled = false;
                    label.classList.remove('opacity-75');
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
    .form-checkbox {
        @apply transition duration-150 ease-in-out;
    }
    
    .form-checkbox:checked {
        @apply bg-primary-600 border-primary-600;
    }
    
    .form-checkbox:focus {
        @apply border-primary-500 ring-2 ring-primary-200;
    }
    
    .form-checkbox:disabled {
        @apply opacity-50 cursor-not-allowed;
    }

    .content-card {
        @apply transition-all duration-300;
    }

    .content-card:hover {
        @apply shadow-xl;
    }

    /* Animasi untuk checkbox */
    .form-checkbox:checked {
        animation: checkmark 0.2s ease-in-out;
    }

    @keyframes checkmark {
        0% {
            transform: scale(0.8);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }

    /* Hover effect untuk card */
    .bg-gray-50:hover {
        @apply shadow-md;
    }

    /* Transisi untuk semua elemen interaktif */
    button, select, input, label {
        @apply transition-all duration-200;
    }
</style>

@endsection 