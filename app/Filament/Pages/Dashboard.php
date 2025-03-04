<?php

// app/Filament/Pages/Dashboard.php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Widgets\CustomerWidget;
use App\Filament\Widgets\TotalPointsWidget;
use App\Filament\Widgets\CustomerStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\RecentTransactionsWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-users';


    public function getSubheading(): ?string
    {
        $user = Auth::user();

        return "Greetings {$user->name} !";
    }

    public function getColumns(): int | string | array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        return [
            CustomerWidget::class,
            TotalPointsWidget::class,
            RecentTransactionsWidget::class,
        ];
    }
}
