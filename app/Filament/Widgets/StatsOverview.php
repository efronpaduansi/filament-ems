<?php

namespace App\Filament\Widgets;

use App\Models\Position;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('All Users', User::query()->count())
                ->description('All the users from the database.')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Inactive Positions', Position::query()->where('status', false)->count())
                ->description('Inactive positions from the database.')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Active Positions', Position::query()->where('status', true)->count())
                ->description('Active positions from the database.')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
