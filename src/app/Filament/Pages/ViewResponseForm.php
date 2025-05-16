<?php

namespace App\Filament\Pages;

use App\Models\Form;
use App\Models\Answer;
use Filament\Pages\Page;
use Filament\Forms;

class ViewResponseForm extends Page
{

    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationLabel = 'Respostas por Formulário';
    protected static string $view = 'filament.pages.view-response-form';

    public $forms;
    public $formulario;
    public $respostasAgrupadas = [];


    public ?array $data = [];

    public function mount(): void
    {
        $this->forms = Form::with('questions')
            ->where('locked', true)
            ->get();

        $this->form->fill();
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


    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make(['sm' => 12])->schema([
                            Forms\Components\Select::make('selectedForm')
                                ->label('Formulários')
                                ->live()
                                ->options(fn()=>Form::query()->pluck('name', 'id')->toArray())
                                ->afterStateUpdated(function($state){
                                    $this->formulario = Form::query()->find($state);
                                })
                                ->required()
                                ->columnSpan([
                                    'lg' => 4,
                                    'md' => 6,
                                    'sm' => 12,
                                ])
                        ])
                    ])
            ])
            ->statePath('data');
    }


}
