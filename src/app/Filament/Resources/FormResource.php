<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Formulários';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->disabled(fn ($record) => $record && $record->locked),
//                Forms\Components\Select::make('questions')
//                    ->label('Perguntas')
//                    ->multiple()
//                    ->relationship('questions', 'title')
//                    ->preload()
//                    ->required()
//                    ->disabled(fn ($record) => $record && $record->locked),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Qtde Perguntas'),
                Tables\Columns\IconColumn::make('locked')
                    ->boolean()
                    ->label('Travado'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->disabled(fn ($record) => $record && $record->locked),
                // Tables\Actions\Action::make('Ver Respostas')
                // ->label('Ver Respostas')
                // ->color('success')
                // ->icon('heroicon-o-eye')
                // ->url(fn ($record) => route('filament.admin.pages.view-response-form', ['formId' => $record->id]))
                // ->visible(fn ($record) => $record && $record->locked),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->action(function (iterable $records) {
                    $lockedRecords = collect($records)->filter(fn ($record) => $record->locked);

                    if ($lockedRecords->isNotEmpty()) {
                        \Filament\Notifications\Notification::make()
                            ->title('Erro')
                            ->body('Não foi possível deletar. Alguns registros estão bloqueados.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Exclui os registros desbloqueados
                    foreach ($records as $record) {
                        $record->delete();
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('Sucesso')
                        ->body('Registros deletados com sucesso.')
                        ->success()
                        ->send();
                }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuestionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
    
}
