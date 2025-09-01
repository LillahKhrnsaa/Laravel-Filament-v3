<?php

namespace App\Filament\Resources\TypeWidgetsResource\Pages;

use App\Filament\Resources\TypeWidgetsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeWidgets extends EditRecord
{
    protected static string $resource = TypeWidgetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
