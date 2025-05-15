<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Perguntas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                ->required()
                ->disabled(fn ($record) => $record && $record->forms()->where('locked', 1)->exists()),
                Forms\Components\Select::make('type')
                    ->options([
                        'multiple_choice' => 'Múltipla Escolha',
                        'text' => 'Texto Aberto',
                    ])
                    ->required()
                    ->reactive()
                    ->disabled(fn ($record) => $record && $record->forms()->where('locked', 1)->exists()),

                Forms\Components\Textarea::make('options')
                    ->label('Opções (JSON)')
                    ->disabled(fn ($record) => $record && $record->forms()->where('locked', 1)->exists()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->disabled(fn ($record) => $record->forms()->where('locked', 1)->exists()),
                Tables\Actions\DeleteAction::make()
                ->disabled(fn ($record) => $record->forms()->where('locked', 1)->exists()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->action(function (iterable $records) {
                        $lockedRecords = collect($records)->filter(fn ($record) => $record->forms()->where('locked', 1)->exists());

                        if ($lockedRecords->isNotEmpty()) {
                            \Filament\Notifications\Notification::make()
                            ->title('Erro')
                            ->body('Não foi possível deletar. Alguns registros estão vinculados a formulários bloqueados.')
                            ->danger()
                            ->send();
                            return;
                        }

                        foreach ($records as $record) {
                            $record->delete();
                        }

                        \Filament\Notifications\Notification::make()
                        ->title('Sucesso')
                        ->body('Registros deletados com sucesso.')
                        ->success()
                        ->send();
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
