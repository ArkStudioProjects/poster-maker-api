<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'name'),
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->state(fn (Category $record) => $record->parent ? $record->parent->name . ' / ' . $record->name : $record->name ),
            ])
            ->filters([
                SelectFilter::make('parent_id')
                    ->label('Type')
                    ->placeholder('Top Level')
                    ->relationship('parent', 'name', fn (Builder $query) => $query->topLevel())
                    ->query( function (Builder $query, array $data) {
                        return $query
                            ->when(isset( $data['value'] ) && $data['value'], function (Builder $query ) use ($data) {
                                return $query->where('parent_id', $data['value']);
                            })
                            ->when(!isset( $data['value'] ) || !$data['value'], function (Builder $query) {
                                return $query->topLevel();
                            });
                    }),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
