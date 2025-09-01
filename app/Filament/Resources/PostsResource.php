<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostsResource\Pages;
use App\Filament\Resources\PostsResource\RelationManagers;
use App\Models\Posts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class PostsResource extends Resource
{
    protected static ?string $model = Posts::class;

    protected static ?string $navigationIcon = 'heroicon-o-Newspaper';

    protected static function afterCreate(Model $record, array $data): void
    {
        if (isset($data['seoMetaKeywords'])) {
            $record->seoMetaKeywords()->sync($data['seoMetaKeywords']);
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->nullable()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') return;
                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->readonly()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish At')
                            ->seconds(false) // hilangkan detik
                            ->displayFormat('d-m-Y H:i')
                            ->format('Y-m-d H:i')
                            ->nullable(),
                            
                        Forms\Components\Textarea::make('preview')
                            ->nullable(),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->directory('posts/thumbnails') // Subfolder khusus
                            ->image()
                            ->visibility('public')
                            ->maxsize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']) 
                            ->preserveFilenames()
                            ->imagePreviewHeight('200')
                            ->columnSpanFull()
                            ->nullable(),

                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('posts/content'),

                        

                    ])->columns(2),
                    Forms\Components\Section::make('Metadata')
                        ->schema([
                            Forms\Components\Select::make('tags')
                                ->relationship('tags', 'name')
                                ->multiple()
                                ->preload()
                                ->searchable(),

                            Forms\Components\Select::make('seoMetaKeywords')
                                ->relationship('seoMetaKeywords', 'meta_title')
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->required()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('seoMetaKeywords', $state);
                                }),
                        ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->square()
                    ->size(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Status Publikasi')
                    ->extraAttributes(['class' => 'transition duration-300 ease-in-out'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->icon('heroicon-m-calendar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(','),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),

                Tables\Filters\TernaryFilter::make('status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->button()
                    ->color('primary')
                    ->extraAttributes(['class' => 'rounded-lg px-3 py-1 text-sm font-medium']),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->button()
                    ->color('danger')
                    ->extraAttributes(['class' => 'rounded-lg px-3 py-1 text-sm font-medium']),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
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
            'index' => Pages\ListPosts::route('/'),
        ];
    }
}
