<?php

namespace App\Filament\Resources\TypeWidgetsResource\Pages;

use App\Filament\Resources\TypeWidgetsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeWidgets extends ListRecords
{
    protected static string $resource = TypeWidgetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
