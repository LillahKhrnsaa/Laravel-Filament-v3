<?php

namespace App\Filament\Resources\SeoMetaKeywordResource\Pages;

use App\Filament\Resources\SeoMetaKeywordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeoMetaKeywords extends ListRecords
{
    protected static string $resource = SeoMetaKeywordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
