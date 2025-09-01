<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplatePagesResource\Pages;
use App\Filament\Resources\TemplatePagesResource\RelationManagers;
use App\Models\TemplatePages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TemplatePagesResource extends Resource
{
    protected static ?string $model = TemplatePages::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manajemen Pages';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Template Pages')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Template Page')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(255)
                            ->placeholder('Masukan Deskripsi Singkat Tag (opsional)')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('status')
                            ->label('Status Aktif')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('secondary'),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Template Page')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status')
                    ->extraAttributes(['class' => 'transition duration-300 ease-in-out'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')   
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable(),   
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTemplatePages::route('/'),
        ];
    }
}
