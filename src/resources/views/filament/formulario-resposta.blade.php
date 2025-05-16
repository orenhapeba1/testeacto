<div class="w-full">
    @foreach ($respostas as $resposta)
        @php
            $question = json_decode($resposta->question_json);
        @endphp
        <div class="border p-4 rounded-md bg-gray-50">
            <p class="text-sm text-gray-600">
                <strong>Pergunta:</strong> {{ $question->title ?? 'Pergunta não encontrada' }}
            </p>
            <p class="text-sm text-gray-800">
                <strong>Resposta:</strong> {{$resposta->answer }}
            </p>
        </div>
    @endforeach
</div>
