<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoMetaKeywordResource\Pages;
use App\Filament\Resources\SeoMetaKeywordResource\RelationManagers;
use App\Models\SeoMetaKeyword;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeoMetaKeywordResource extends Resource
{
    protected static ?string $model = SeoMetaKeyword::class;

    protected static ?string $slug = 'seo-meta-keywords';

    protected static ?string $navigationGroup = 'Manajemen Posts';

    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Masukan Meta Title SEO'),
                        
                        Forms\Components\TagsInput::make('keyword')
                            ->placeholder('Contoh: laravel,filament,seo')
                            ->splitKeys([',', ' '])
                            ->columnSpanFull()
                            ->required()
                            ->dehydrateStateUsing(function ($state) {
                                // Pastikan format: "laravel,filament,seo"
                                return is_array($state) 
                                    ? implode(',', $state) 
                                    : preg_replace('/\s*,\s*/', ',', $state);
                            }),
                        Forms\Components\Textarea::make('meta_desc')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Masukan Meta Description SEO (opsional)'),
                    ])->columns(2)->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('meta_title')
                    ->label('Meta Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keyword')
                    ->badge()
                    ->separator(','),
                Tables\Columns\TextColumn::make('meta_desc')
                    ->label('Meta Description')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('posts_count') 
                    ->counts('posts')
                    ->label('Jumlah Post'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSeoMetaKeywords::route('/'),
        ];
    }
}
