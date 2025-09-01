<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Companies;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\CheckboxList;
use App\Models\Permission;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User')
                    ->description('Masukkan detail untuk pengguna baru.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukan Nama Lengkap')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // "Budi Santoso" => "budi_santoso"
                                $username = Str::slug($state, '_');
                                $set('username', $username);
                            }),

                        Forms\Components\TextInput::make('username')
                            ->label('Username')
                            ->readonly()
                            ->placeholder('Otomatis diisi dari nama lengkap')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->placeholder('contoh@email.com'),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable() // 👁️ bisa show/hide
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255),

                        Forms\Components\Select::make('roles')
                            ->label('Role')
                            ->multiple()
                            ->relationship('roles', 'display_name')
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('active')
                            ->label('Status')
                            ->options([
                                1 => 'Aktif',
                                0 => 'Tidak Aktif',
                            ])
                            ->placeholder('Pilih Status')
                            ->required(),
                    ])->columns(2), // <-- semua masih dalam 1 section
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope-open')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->searchable()
                    ->icon('heroicon-o-shield-check')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Status')
                    ->searchable()
                    ->extraAttributes(['class' => 'transition duration-300 ease-in-out'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat Pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-o-calendar'), 
            ])
            ->filters([
                //
            ])
            ->actions([
        Tables\Actions\Action::make('companies')
            ->icon('heroicon-o-building-office')
            ->label('Kelola Perusahaan') // Tambahkan label untuk tooltip
            ->modalHeading(fn ($record) => "Kelola Perusahaan untuk {$record->name}")
            ->modalSubmitActionLabel('Simpan Perubahan')
            ->modalWidth('4xl')
            ->form([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Perusahaan yang Tersedia')
                            ->schema([
                                Forms\Components\Select::make('company_ids') // Ubah kembali ke company_ids (plural)
                                    ->label('Pilih Perusahaan')
                                    ->options(function () {
                                        return Companies::query()->orderBy('name')->pluck('name', 'id');
                                    })
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Cari dan pilih perusahaan untuk dihubungkan dengan pengguna ini.')
                                    ->required(),
                            ]),
                        Forms\Components\Section::make('Perusahaan yang Terhubung')
                            ->schema([
                                Forms\Components\Placeholder::make('connected_info')
                                    ->content(function ($record) {
                                        $count = $record->companies->count();
                                        return "{$count} perusahaan terhubung saat ini";
                                    }),
                                Forms\Components\CheckboxList::make('current_companies')
                                    ->label('')
                                    ->options(function ($record) {
                                        return $record->companies->pluck('name', 'id');
                                    })
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->gridDirection('column')
                                    ->columns(1)
                            ]),
                    ]),
            ])
            ->action(function ($record, array $data) {
                try {
                    // Sync companies (automatically prevents duplicates)
                    $record->companies()->sync($data['company_ids']);
                    
                    Notification::make()
                        ->title('Perusahaan berhasil diperbarui')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Error memperbarui perusahaan')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->mountUsing(function ($record, Forms\Form $form) {
                // Load currently connected companies
                $form->fill([
                    'company_ids' => $record->companies->pluck('id')->toArray(),
                ]);
            }),
        Tables\Actions\EditAction::make()
            ->label('Edit'), // Ubah label edit ke Bahasa Indonesia
        Tables\Actions\DeleteAction::make()
            ->label('Hapus'), // Ubah label delete ke Bahasa Indonesia
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
