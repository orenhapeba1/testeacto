<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->disabled(fn($record) => $record && $record->forms()->where('locked', 1)->exists()),
                Forms\Components\Select::make('type')
                    ->options([
                        'multiple_choice' => 'Múltipla Escolha',
                        'text' => 'Texto Aberto',
                    ])
                    ->required()
                    ->reactive()
                    ->disabled(fn($record) => $record && $record->forms()->where('locked', 1)->exists()),

                Forms\Components\Textarea::make('options')
                    ->label('Opções (JSON)')
                    ->disabled(fn($record) => $record && $record->forms()->where('locked', 1)->exists()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Vincular Pergunta')
                    ->form([
                        Forms\Components\Select::make('perguntas')
                            ->options(Question::query()->pluck('title', 'id')->toArray())
                            ->multiple()
                    ])
                    ->action(function ($data) {
                        $this->ownerRecord->questions()->sync($data['perguntas']);
                        Notification::make()
                            ->title('Sucesso')
                            ->body('Perguntas Vinculadas com Sucesso.')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
