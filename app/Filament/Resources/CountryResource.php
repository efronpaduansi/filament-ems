<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationLabel = 'Daftar Negara';
    protected static ?string $navigationGroup = 'Sistem Manajemen';
    protected static ?string $modelLabel = 'Negara';
    protected static ?string $slug = 'sistem-manajemen/countries';
    protected static ?int $navigationSort = 1;

    //Menampilkan record pada form global search
    protected static ?string $recordTitleAttribute = 'name'; //Artinya, nama negara bisa dicari melalui form global search

    //Memungkinkan pengguna mencari beberapa data dari form global search melalui beberapa kolom sekaligus.
    public static  function getGloballySearchableAttributes(): array
    {
        return [
            'code', 'name', 'phonecode'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode')
                    ->placeholder('Masukan Kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Negara')
                    ->placeholder('Masukan Nama Negara')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phonecode')
                    ->label('Kode Telepon')
                    ->placeholder('Masukan Kode Telepon')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phonecode')
                    ->label('Kode Telepon')
                    ->numeric()
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Detail')->schema([
                    TextEntry::make('code')->label('Kode'),
                    TextEntry::make('name')->label('Nama'),
                    TextEntry::make('phonecode')->label('Kode Telepon'),
                ])
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
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
