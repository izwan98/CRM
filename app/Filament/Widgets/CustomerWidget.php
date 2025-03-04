<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class CustomerWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::where('business_id', Auth::user()->id)->count())
                ->description('Total number of registered customers')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),
        ];
    }
}
