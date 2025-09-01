<?php

namespace App\Filament\Resources\SeoMetaKeywordResource\Pages;

use App\Filament\Resources\SeoMetaKeywordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeoMetaKeyword extends EditRecord
{
    protected static string $resource = SeoMetaKeywordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
