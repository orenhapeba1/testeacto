<?php

namespace App\Filament\Pages;

use App\Livewire\FillForm;
use App\Models\Form;
use App\Models\Answer;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewResponseForm extends Page implements HasTable
{
    use InteractsWithTable;
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


    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $respostas = Answer::query()->with('form');
                if (!empty($this->formulario->id)) {
                    $respostas = $respostas->where('form_id', $this->formulario->id);
                }
                $respostas = $respostas->select('id','token_answer','form_id')
                    ->groupBy('token_answer');

                return $respostas;
            })
            ->columns([
                TextColumn::make('token_answer'),
                TextColumn::make('form.name'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('Visualizar')
                ->modalContent(function($record){

                    $respostas = Answer::query()->with('form')
                    ->where('token_answer', $record['token_answer'])
                    ->get();
                    return view('filament.formulario-resposta',['respostas'=>$respostas]);
                })

            ])
            ->bulkActions([
                // ...
            ]);
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
                                ->options(fn() => Form::query()->pluck('name', 'id')->toArray())
                                ->afterStateUpdated(function ($state) {
                                    $this->formulario = Form::query()->find($state);
                                    $this->updatedSelectedForm($state);
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
