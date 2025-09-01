<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WidgetsResource\Pages;
use App\Models\Widgets;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Pages as modelPages;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class WidgetsResource extends Resource
{
    protected static ?string $model = Widgets::class;
    protected static ?string $navigationLabel = 'Widgets';

    protected static ?string $navigationGroup = 'Manajemen Pages';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Widget Details')
                    ->schema([
                        Forms\Components\Select::make('page_id')
                            ->label('Page')
                            ->relationship('page', 'title')
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Widget Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('type_id')
                            ->label('Widget Type')
                            ->relationship('type', 'title')
                            ->required(),

                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->label('Order'),

                        Forms\Components\KeyValue::make('settings')
                            ->label('Settings')
                            ->keyLabel('Setting Key')
                            ->valueLabel('Setting Value')
                            ->addActionLabel('Add Setting')
                            ->nullable()
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('page.title')
                ->label('Page')
                ->sortable()
                ->searchable(),

            TextColumn::make('name')
                ->label('Name')
                ->sortable()
                ->searchable(),

            TextColumn::make('type.title')
                ->badge(),

            TextColumn::make('order')
                ->sortable(),

            ToggleColumn::make('is_active')
                ->label('Status ')
                ->extraAttributes(['class' => 'transition duration-300 ease-in-out'])
                ->sortable(),

            Tables\Columns\TextColumn::make('settings')
                ->label('Settings')
                ->state(function ($record) {
                    $data = $record->settings;
                    if (! is_array($data) || $data === []) {
                        return '-';
                    }

                    return collect($data)
                        ->map(fn ($value, $key) => "{$key} : {$value}")
                        ->implode('<br>');
                })
                ->html(),




            TextColumn::make('created_at')
                ->dateTime('d M Y H:i')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),

            TextColumn::make('updated_at')
                ->dateTime('d M Y H:i')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Active Status')
                ->boolean(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListWidgets::route('/'),
        ];
    }
}
