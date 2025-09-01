<?php

namespace App\Filament\Resources\WidgetsResource\Pages;

use App\Filament\Resources\WidgetsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWidgets extends EditRecord
{
    protected static string $resource = WidgetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
