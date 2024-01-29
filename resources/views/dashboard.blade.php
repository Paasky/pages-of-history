<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <x-primary-button>
                    <i class="fa-solid fa-flask"></i> Tech Tree
                </x-primary-button>
                <x-primary-button onclick="openModal('unit-designer')">
                    <i class="fa-solid fa-screwdriver-wrench"></i> {{ __('Unit Designer') }}
                </x-primary-button>
                <x-primary-button>
                    <i class="fa-solid fa-circle-question"></i> Game Concepts
                </x-primary-button>
            </div>
            <div>
                <x-primary-button title="Tech Tree">
                    <i class="fa-solid fa-flask"></i>
                </x-primary-button>
                <x-primary-button title=" {{ __('Unit Designer') }}" onclick="openModal('unit-designer')">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </x-primary-button>
                <x-primary-button title="Game Concepts">
                    <i class="fa-solid fa-circle-question"></i>
                </x-primary-button>
            </div>
        </div>
    </div>
    <livewire:unit-designer lazy/>
    <script>
        function openModal(name) {
            window.dispatchEvent(new CustomEvent('open-modal', {detail: name}));
        }
    </script>
</x-app-layout>
