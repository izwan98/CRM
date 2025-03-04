<?php

namespace App\Filament\Widgets;

use App\Models\Point;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentTransactionsWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Point::where('business_id', Auth::id())
                    ->with('customer')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('points')
                    ->label('Points')
                    ->sortable()
                    ->color(fn(Point $record): string => $record->points > 0 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(30),
            ]);
    }
}
