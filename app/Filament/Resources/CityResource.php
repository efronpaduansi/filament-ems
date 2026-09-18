<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationLabel = 'Daftar Kota';
    protected static ?string $modelLabel = 'Kota';
    protected static ?string $navigationGroup = 'Sistem Manajemen';
    protected static ?string $slug = 'sistem-manajemen/cities';
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name'; //Artinya, nama kota bisa dicari melalui form global search

    //Memungkinkan pengguna mencari beberapa data dari form global search melalui beberapa kolom sekaligus.
    public static  function getGloballySearchableAttributes(): array
    {
        return [
            'name'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('state_id')
                    ->relationship('state', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Pilih Provinsi')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Kota')
                    ->placeholder('Masukan Nama Kota')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('state.name')
                    ->label('Provinsi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Provinsi')
                ->relationship('state', 'name')
                ->searchable()
                ->preload()
                ->label('Filter by State')
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
