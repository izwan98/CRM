<?php

namespace App\Filament\Widgets;

use App\Models\Point;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TotalPointsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $businessId = Auth::id();

        return [
            Stat::make('Total Points Issued', Point::where('business_id', $businessId)
                ->where('points', '>', 0)->sum('points'))
                ->description('Sum of all issued loyalty points')
                ->descriptionIcon('heroicon-o-plus-circle')
                ->color('primary'),

            Stat::make('Total Points Redeemed', abs(Point::where('business_id', $businessId)
                ->where('points', '<', 0)->sum('points')))
                ->description('Sum of all redeemed loyalty points')
                ->descriptionIcon('heroicon-o-minus-circle')
                ->color('warning'),

            Stat::make('Unassigned Points', Point::where('business_id', $businessId)
                ->whereNull('customer_id')->sum('points'))
                ->description('Points not assigned to any customer')
                ->descriptionIcon('heroicon-o-question-mark-circle')
                ->color('danger'),
        ];
    }
}
