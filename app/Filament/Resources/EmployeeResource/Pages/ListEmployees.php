<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;


class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    //Menampilkan tabs di halaman list employees
//    public function getTabs(): array
//    {
//        [
//            'All' => Tab::make(),
//            'This Week' => Tab::make()
//                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_hired', '>=', now()->subWeek())),
////            'inactive' => Tab::make()
////                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false)),
//        ];
//    }
}
