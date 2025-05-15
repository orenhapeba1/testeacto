<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->disabled(fn () => $this->record->forms->contains('locked', 1)),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->forms->contains('locked', 1)) {
            abort(403, 'This question cannot be edited because it belongs to a locked form.');
        }

        return $data;
    }
}
