<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <x-primary-button onclick="openModal('tech-tree')">
                    <i class="fa-solid fa-flask"></i> {{ __('Tech Tree') }}
                </x-primary-button>
                <x-primary-button onclick="openModal('unit-designer')">
                    <i class="fa-solid fa-screwdriver-wrench"></i> {{ __('Unit Designer') }}
                </x-primary-button>
                <x-primary-button onclick="openModal('game-concepts')">
                    <i class="fa-solid fa-circle-question"></i> {{ __('Game Concepts') }}
                </x-primary-button>
            </div>
            <div>
                <x-primary-button title="{{ __('Tech Tree') }}" onclick="openModal('tech-tree')">
                    <i class="fa-solid fa-flask"></i>
                </x-primary-button>
                <x-primary-button title=" {{ __('Unit Designer') }}" onclick="openModal('unit-designer')">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </x-primary-button>
                <x-primary-button title="{{ __('Game Concepts') }}" onclick="openModal('game-concepts')">
                    <i class="fa-solid fa-circle-question"></i>
                </x-primary-button>
            </div>
        </div>
    </div>
    <livewire:unit-designer/>
    <livewire:game-concepts/>
    <livewire:tech-tree/>
    <script>
        function openModal(name) {
            console.log('openModal', name);
            window.dispatchEvent(new CustomEvent('open-modal', {detail: name}));
            if (name === 'tech-tree') {
                drawTechArrows();
            }
        }

        function scrollToModal(name) {
            console.log('scrollToModal', `#${name} .modal-content`);
            document.querySelector(`#${name} .modal-content`).scrollIntoView({behavior: 'smooth'})
        }
    </script>
</x-app-layout>
