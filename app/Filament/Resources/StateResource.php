<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static  ?string $navigationLabel = 'Daftar Provinsi';
    protected static ?string $navigationGroup = 'Sistem Manajemen';
    protected static ?string $slug = 'sistem-manajemen/states';
    protected static ?string $modelLabel = 'Provinsi';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name'; //Artinya, nama provinsi bisa dicari melalui form global search

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
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Pilih Negara')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Provinsi')
                    ->placeholder('Masukan Nama Provinsi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.code')
                    ->numeric()
                    ->label('Kode Negara'),
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Negara')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])->defaultSort('country.name', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('Negara')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by country'),
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
