<?php

namespace App\Filament\Pages;

use App\Models\Form;
use App\Models\Answer;
use Filament\Pages\Page;
use Livewire\Component;
use Filament\Forms;

class ViewResponseForm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationLabel = 'Respostas por Formulário';
    protected static string $view = 'filament.pages.view-response-form';

    public $forms;
    public $selectedForm = null;
    public $respostasAgrupadas = [];

    public function mount(): void
    {
        $this->forms = Form::with('questions')
        ->where('locked', true)
        ->get();
    }

    public function updatedSelectedForm($formId)
    {
        $this->selectedForm = Form::where('id', $formId)
        ->where('locked', true);

        $this->respostasAgrupadas = Answer::with('question')
            ->where('form_id', $formId)
            ->get()
            ->groupBy('token_answer');
    }

    protected function getViewData(): array
    {
        return [
            'forms' => $this->forms,
            'selectedForm' => $this->selectedForm,
            'respostasAgrupadas' => $this->respostasAgrupadas,
        ];
    }
}
