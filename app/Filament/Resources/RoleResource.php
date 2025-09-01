<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Role')
                    ->description('Masukkan detail untuk role baru.')
                    ->schema([
                        Forms\Components\TextInput::make('display_name')
                            ->label('Nama Role')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Admin')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Mengonversi string:
                                // 'Admin' menjadi 'admin'
                                $name = Str::slug($state);
                                $set('name', $name);
                            }),
                        
                        Forms\Components\TextInput::make('name')
                            ->label('Display Name')
                            ->placeholder('Otomatis diisi dari nama role')
                            ->readonly()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(500)
                            ->placeholder('Contoh: Role dengan akses penuh ke sistem.'),
                    ]),
                Forms\Components\Hidden::make('guard_name')
                    ->default('web'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Role')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->label('Nama Role')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50),
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
            ->headerActions([
                //,
            ])
            ->actions([
            Tables\Actions\Action::make('manage_permissions')
                ->label('Kelola Izin')
                ->icon('heroicon-o-key')
                ->modalHeading('Kelola Akses Role')
                ->form(function (Role $record): array {
                    // Ambil & kelompokkan permission berdasarkan segmen ke-2 (create.users => users)
                    $groups = Permission::query()
                        ->orderBy('name')
                        ->get()
                        ->groupBy(fn ($p) => explode('.', $p->name)[1] ?? 'general');

                    return [
                        Tabs::make('PermissionsTabs')->tabs(
                            $groups->map(function ($perms, $entity) use ($record) {
                                // Opsi & default khusus untuk grup tab ini
                                $options  = $perms->pluck('display_name', 'name')->all();
                                $defaults = $record->permissions
                                    ->pluck('name')
                                    ->filter(fn ($n) => array_key_exists($n, $options))
                                    ->values()
                                    ->all();

                                return Tab::make(Str::headline($entity))
                                    ->schema([
                                        CheckboxList::make("permissions_{$entity}")
                                            ->label("Izin {$entity}")
                                            ->options($options)
                                            ->default($defaults)
                                            ->columns(2),
                                    ]);
                            })->values()->all()
                        ),
                    ];
                })
                ->action(function (array $data, \App\Models\Role $record) {
                    // Gabungkan semua checkbox yang dicentang dari semua tab
                    $selected = collect($data)
                        ->flatMap(fn ($v) => $v ?? [])
                        ->values()
                        ->all();

                    $record->syncPermissions($selected);
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
            'index' => Pages\ListRoles::route('/'),
        ];
    }
}
