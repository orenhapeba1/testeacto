<?php
namespace App\Livewire;

use App\Models\Form;
use App\Models\Answer;
use Livewire\Component;
use Illuminate\Support\Str;

class FillForm extends Component
{
    public Form $form;
    public array $responses = [];

    public function mount(Form $form)
    {
    
        $this->form = $form;

        // Inicializa campos
        foreach ($form->questions as $question) {
            $this->responses[$question->id] = null;
        }
    }

    public function save()
    {
        $token_answer = $token_answer = Str::random(32);
        foreach ($this->form->questions as $question) {
            $answer = $this->responses[$question->id];

            // Validação simples
            if ($question->type === 'text' && empty($answer)) {
                $this->addError('responses.' . $question->id, 'Campo obrigatório.');
            }

            Answer::create([
                'form_id' => $this->form->id,
                'question_id' => $question->id,
                'token_answer' => $token_answer,
                'answer' => is_array($answer) ? json_encode($answer) : $answer,
            ]);
        }

        // Bloqueia edição
        $this->form->update(['locked' => true]);

        session()->flash('success', 'Respostas salvas com sucesso!');
        return redirect('/'); // ou para página de visualização
    }

    public function render()
    {
        return view('livewire.fill-form')->with('layout', 'layouts.app');
    }
}
