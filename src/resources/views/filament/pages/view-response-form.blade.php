<x-filament::page>
    <style>
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="space-y-6">
        {{--        <form wire:submit.prevent>--}}
        {{--            <x-filament::forms>--}}
        {{--                <select--}}
        {{--                        label="Selecione um formulário"--}}
        {{--                        wire:model="selectedForm"--}}
        {{--                >--}}
        {{--                    <option value="">-- Escolha --</option>--}}
        {{--                    @foreach($forms as $form)--}}
        {{--                        <option value="{{ $form->id }}">{{ $form->name }}</option>--}}
        {{--                    @endforeach--}}
        {{--                </select>--}}
        {{--            </x-filament::forms>--}}
        {{--        </form>--}}
        {{$this->form}}

        <div>

            <!-- Seu código existente -->
            @if (!empty($this->data['selectedForm']))
                <h2 class="text-xl font-bold mt-6">Respostas para: {{ $this->formulario->name }}</h2>
                
                @forelse ($this->formulario->answers as $token => $respostas)
                    <div class="border rounded p-4 mb-4 bg-white shadow">
                        <h3 class="text-lg font-semibold text-blue-600">Token: {{ $token }}</h3>

                        <ul class="mt-2 space-y-2">
                            @foreach ($respostas->original as $resposta)
                                <li>
                                    <strong>{{ $resposta->question_id }}:</strong>
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
    </div>
</x-filament::page>
