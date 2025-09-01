<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompaniesResource\Pages;
use App\Filament\Resources\CompaniesResource\RelationManagers;
use App\Models\Companies;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompaniesResource extends Resource
{
    protected static ?string $model = Companies::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Manajemen Entity';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Perusahaan')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Masukan Nama Perusahaan')
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $words = explode(' ', $state);
                                $initials = [];
                                foreach ($words as $word) {
                                    // Lewati kata 'PT', 'CV', 'PD', dsb. (bisa tambah sesuai kebutuhan)
                                    if (in_array(strtoupper($word), ['PT', 'CV', 'PD'])) {
                                        continue;
                                    }
                                    $initials[] = strtoupper(mb_substr($word, 0, 1));
                                }
                                $alias = implode('', $initials);
                                $set('alias', $alias);
                            }),

                        Forms\Components\TextInput::make('alias')
                            ->label('Alias')
                            ->maxLength(20)
                            ->readonly()
                            ->placeholder('otomatis terisi berdasarkan nama perusahaan'),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Active',
                                0 => 'Inactive',
                            ])
                            ->default(1)
                            ->required(),

                    ])->columnSpan(12)->columns(2),

                Forms\Components\Section::make('Detail Kontak & Alamat')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Perusahaan')
                            ->rows(3)
                            ->placeholder('Masukan Alamat Perusahaan'),

                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon Perusahaan')
                            ->maxLength(50)
                            ->placeholder('Masukan Nomor Telepon Perusahaan'),

                        Forms\Components\TextInput::make('postal_code')
                            ->label('Kode Pos Perusahaan')
                            ->maxLength(50)
                            ->placeholder('Nasukan Kode Pos Perusahaan'),

                    ])->columnSpan(12)->columns(2),
                
                Forms\Components\Section::make('Detail Lainnya')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('companies/logo') // simpan di storage/app/public/companies/logo
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                            ->nullable(),
                    ])->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(), 

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Induk Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->default('-'), 
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status')
                    ->extraAttributes(['class' => 'transition duration-300 ease-in-out'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->icon('heroicon-m-calendar'), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('manage_children')
                    ->authorize('manageChildren')
                    ->label('Anak Perusahaan')
                    ->icon('heroicon-o-building-office-2')
                    ->modalHeading('Kelola Anak Perusahaan')
                    ->modalWidth('2xl')
                    ->form(function ($record) {
                        return [
                            Forms\Components\Select::make('children_ids')
                                ->label('Pilih Anak Perusahaan')
                                ->multiple()
                                ->options(
                                    Companies::query()
                                        ->where('id', '!=', $record->id)
                                        ->pluck('name', 'id')
                                        ->toArray()
                                )
                                ->default($record->children()->pluck('id')->toArray())
                                ->searchable()
                                ->preload(),
                        ];
                    })
                    ->action(function ($record, array $data) {
                        // reset dulu anak perusahaan lama
                        $record->children()->update(['parent_id' => null]);

                        // assign ulang
                        if (! empty($data['children_ids'])) {
                            Companies::whereIn('id', $data['children_ids'])
                                ->update(['parent_id' => $record->id]);
                        }
                    }),

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
            'index' => Pages\ListCompanies::route('/'),
        ];
    }
}
