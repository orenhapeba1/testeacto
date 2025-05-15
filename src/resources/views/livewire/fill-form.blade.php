<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Responder: {{ $form->name }}</h2>

    <form wire:submit.prevent="save" class="space-y-6">
        @foreach($form->questions as $question)
            <div>
                <label class="block font-semibold mb-1">{{ $question->title }}</label>

                @if($question->type === 'text')
                    <input type="text" wire:model.defer="responses.{{ $question->id }}"
                           class="w-full border rounded p-2">
                    @error("responses.{$question->id}") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @elseif($question->type === 'multiple_choice')
                    @foreach(json_decode($question->options, true) as $option)
                        <label class="inline-flex items-center space-x-2 mr-4">
                            <input type="radio"
                                   wire:model.defer="responses.{{ $question->id }}"
                                   value="{{ $option }}">
                            <span>{{ $option }}</span>
                        </label>
                    @endforeach
                @endif
            </div>
        @endforeach

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Enviar Respostas
        </button>
    </form>

    @if (session()->has('success'))
        <div class="mt-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif
</div>
