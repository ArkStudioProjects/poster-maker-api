<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesignResource\Pages;
use App\Models\Design;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class DesignResource extends Resource
{
    protected static ?string $model = Design::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('category_id')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->required(),
                TagsInput::make('keywords'),
                Placeholder::make('preview')
                    ->content(fn (Design $record) => new HtmlString('<a target="_blank" href="' . $record->getFirstMediaUrl('preview') . '" target="_blank"><img src="' . $record->getFirstMediaUrl('preview') . '" alt="' . $record->title . '"></a>')),
                Section::make('data')
                    ->collapsed()
                    ->schema([
                        Placeholder::make('data')
                            ->label(false)
                            ->content(fn (Design $record) => new HtmlString('<pre>' . json_encode($record->data, JSON_PRETTY_PRINT) . '</pre>')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('categories.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('keywords')
                    ->badge(),
                ImageColumn::make('preview')
                    ->state(fn (Design $record) => $record->getFirstMediaUrl('preview', 'thumbnail')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([])
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
            'index' => Pages\ListDesigns::route('/'),
            'edit' => Pages\EditDesign::route('/{record}/edit'),
        ];
    }
}
