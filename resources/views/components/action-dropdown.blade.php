@props([
    'align' => 'right'
])

<div 
    x-data="{ open: false }" 
    class="action-dropdown"
>
    <button 
        @click="open = !open" 
        class="action-dropdown-toggle"
        type="button"
    >
        <i class="ri-more-2-fill"></i>
    </button>

    <div 
        x-cloak
        x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="action-dropdown-menu {{ $align === 'right' ? 'right-0' : 'left-0' }}"
    >
        {{ $slot }}
    </div>
</div>

<style>
[x-cloak] { 
    display: none !important; 
}

.action-dropdown {
    position: relative;
    display: inline-block;
}

.action-dropdown-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
}

.action-dropdown-toggle:hover {
    background: #f8fafc;
    color: var(--primary-color);
}

.action-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 0.25rem;
    min-width: 12rem;
    width: max-content;
    max-width: 16rem;
    padding: 0.5rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    z-index: 999;
    transform-origin: top right;
}

.action-dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    color: #1e293b;
    font-size: 0.875rem;
    border-radius: 0.25rem;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.action-dropdown-item:hover {
    background: #f8fafc;
    color: var(--primary-color);
}

.action-dropdown-item i {
    font-size: 1rem;
    opacity: 0.8;
    flex-shrink: 0;
}

.action-dropdown-divider {
    margin: 0.5rem -0.5rem;
    border-top: 1px solid #e2e8f0;
}

/* Ensure dropdown doesn't cause horizontal scroll */
.dashboard-section {
    overflow-x: hidden;
}
</style> 