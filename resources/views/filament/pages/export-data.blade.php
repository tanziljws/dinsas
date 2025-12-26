<x-filament-panels::page>
    <x-filament-panels::form wire:submit="export">
        {{ $this->form }}

        <div class="flex justify-end gap-x-3">
            <x-filament::button type="submit" color="success" icon="heroicon-o-arrow-down-tray">
                Download Excel
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>