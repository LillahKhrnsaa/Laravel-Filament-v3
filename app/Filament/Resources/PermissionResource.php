<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PermissionResource extends Resource
{
    // Menggunakan model Permission Anda
    protected static ?string $model = Permission::class;

    // Tentukan icon navigasi di sidebar
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $modelLabel = 'Permission';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Permission')
                    ->description('Masukkan detail untuk permission baru.')
                    ->schema([
                        Forms\Components\TextInput::make('display_name')
                            ->label('Nama Permission')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Rotasi Shift')
                            // Memperbarui field `name` secara otomatis
                            ->live(onBlur: true) // Memperbarui saat user keluar dari field
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Mengonversi string:
                                // 'Rotasi Shift' menjadi 'rotasi-shift'
                                $name = Str::slug($state);

                                // Mengubah '-' menjadi '.'
                                // 'rotasi-shift' menjadi 'rotasi.shift'
                                $name = str_replace('-', '.', $name);

                                // Mengisi field name yang tersembunyi
                                $set('name', $name);
                            }),

                        // Menambahkan field deskripsi di sini
                        Forms\Components\TextInput::make('description')
                            ->label('Deskripsi')
                            ->maxLength(255)
                            ->placeholder('Contoh: Mengizinkan pengguna untuk merotasi shift secara manual.'),
                    ]),

                // Field name ini akan diisi otomatis, tersembunyi dari user
                Forms\Components\Hidden::make('name')
                    ->required(),

                // Guard name dari Spatie, bisa disembunyikan
                Forms\Components\Hidden::make('guard_name')
                    ->default('web'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('display_name')
                    ->label('Display Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Permission Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat Pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-o-calendar'), // Menambahkan ikon kalender
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                // Menggunakan EditAction untuk mengedit item dalam modal
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
            // Hanya satu halaman: ListPermissions
            'index' => Pages\ListPermissions::route('/'),
        ];
    }
}
