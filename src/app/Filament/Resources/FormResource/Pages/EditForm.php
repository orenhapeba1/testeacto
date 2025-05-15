<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->disabled(fn () => $this->record->locked === 1),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->locked === 1) {
            abort(403, 'This form cannot be edited because it has been answered.');
        }

        return $data;
    }
}
