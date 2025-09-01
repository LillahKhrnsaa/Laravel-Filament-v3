<?php

namespace App\Filament\Resources\TemplatePagesResource\Pages;

use App\Filament\Resources\TemplatePagesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemplatePages extends ListRecords
{
    protected static string $resource = TemplatePagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
