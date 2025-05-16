<?php

namespace App\Livewire;

use App\Models\Form;
use App\Models\Answer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Illuminate\Support\Str;

class FillForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];


    public $formulario;
    public array $responses = [];

    public function mount(Form $formulario)
    {
        $this->formulario = $formulario;
        $this->form->fill();

    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema($this->getQuestions())
            ->statePath('data');
    }

    public function getQuestions(): array
    {
        $questoes = [];
        foreach ($this->formulario->questions as $question) {
            if ($question->type === 'text') {
                $questoes[] = TextInput::make($question->id)
                    ->label($question->title)
                    ->columnSpanFull();
            } elseif ($question->type === 'multiple_choice') {
                $questoes[] = Select::make($question->id)
                    ->label($question->title)
                    ->options(function () use ($question) {
                        $options = json_decode($question->options, true); // Decodifica o JSON
                        return array_combine($options, $options); // Usa os mesmos valores para chave e texto
                    })
                    ->columnSpanFull();
            }
        }
        return $questoes;
    }

    public function save()
    {
        $token_answer = Str::random(32);
        foreach ($this->formulario->questions as $question) {
            $answer = $this->data[$question->id] ?? null;
            // Validação simples
            if ($question->type === 'text' && empty($answer)) {
                $this->addError('responses.' . $question->id, 'Campo obrigatório.');
            }

            Answer::create([
                'form_id' => $this->formulario->id,
                'question_id' => $question->id,
                'token_answer' => $token_answer,
                'answer' => is_array($answer) ? json_encode($answer) : $answer,
            ]);
        }

        // Bloqueia edição
        $this->formulario->update(['locked' => true]);

        session()->flash('success', 'Respostas salvas com sucesso!');
        return redirect('/'); // ou para página de visualização
    }

    public function render()
    {
        return view('livewire.fill-form')->layout('layouts.app');
    }
}
