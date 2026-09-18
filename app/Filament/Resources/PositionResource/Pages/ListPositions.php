<?php

namespace App\Filament\Resources\PositionResource\Pages;

use App\Filament\Resources\PositionResource;
use App\Models\Position;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPositions extends ListRecords
{
    protected static string $resource = PositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    //Menampilkan Tabs pada halaman list Jabatan (Position)
    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make(),
            'Aktif' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', true))
                ->badge(Position::query()->where('status', true)->count())->badgeColor('success'),
            'Tidak Aktif' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', false))
                ->badge(Position::query()->where('status', false)->count())->badgeColor('danger'),
        ];
    }
}
