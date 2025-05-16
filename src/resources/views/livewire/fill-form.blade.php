<div class="max-w-2xl mx-auto p-6 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl shadow">
    <form wire:submit="save">
        {{ $this->form }}
            <x-filament::button type="submit" color="success">
                Enviar
            </x-filament::button>
    </form>
</div>
