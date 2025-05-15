<x-filament::page>
    <div class="space-y-6">
        <form wire:submit.prevent>
            <x-filament::forms\select
                label="Selecione um formulário"
                wire:model="selectedForm"
            >
                <option value="">-- Escolha --</option>
                @foreach($forms as $form)
                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                @endforeach
            </x-filament::forms\select>
        </form>

        @if ($selectedForm)
            <h2 class="text-xl font-bold mt-6">Respostas para: {{ $selectedForm->name }}</h2>

            @forelse ($respostasAgrupadas as $token => $respostas)
                <div class="border rounded p-4 mb-4 bg-white shadow">
                    <h3 class="text-lg font-semibold text-blue-600">Token: {{ $token }}</h3>

                    <ul class="mt-2 space-y-2">
                        @foreach ($respostas as $resposta)
                            <li>
                                <strong>{{ $resposta->question->title }}:</strong>
                                {{ $resposta->answer }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-gray-500">Nenhuma resposta encontrada.</p>
            @endforelse
        @endif
    </div>
</x-filament::page>
