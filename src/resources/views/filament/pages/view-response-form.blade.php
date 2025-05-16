{{-- resources/views/filament/pages/view-response-form.blade.php --}}
<x-filament::page>
    <div class="space-y-6">
        {{-- Renderiza o formulário Filament --}}
        {{ $this->form }}

        @if ($formulario)
            <x-filament::section>
                <x-slot name="title">
                    Respostas do formulário: <strong>{{ $formulario->name }}</strong>
                </x-slot>

                @forelse ($respostasAgrupadas as $token => $respostas)
                    <x-filament::card class="mb-4">
                        <h3 class="text-lg font-bold text-primary">Token: {{ $token }}</h3>

                        <div class="space-y-2 mt-4">
                            @foreach ($respostas as $resposta)
                                <div class="border p-4 rounded-md bg-gray-50">
                                    <p class="text-sm text-gray-600">
                                        <strong>Pergunta:</strong> {{ $resposta->question->title ?? 'Pergunta não encontrada' }}
                                    </p>
                                    <p class="text-sm text-gray-800">
                                        <strong>Resposta:</strong> {{ $resposta->answer }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </x-filament::card>
                @empty
                    <p class="text-gray-500">Nenhuma resposta encontrada para este formulário.</p>
                @endforelse
            </x-filament::section>
        @endif
    </div>
</x-filament::page>
