<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models\Point;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PointsRelationManager extends RelationManager
{
    protected static string $relationship = 'points';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->default(0),
                ToggleButtons::make('points_type')
                    ->label('Points Type')
                    ->options([
                        'add' => 'Add Points',
                        'deduct' => 'Deduct Points',
                    ])
                    ->default('add')
                    ->inline()
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('points')
                    ->sortable()
                    ->color(fn(Point $record): string => $record->points > 0 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data, RelationManager $livewire): Point {
                        if ($data['points_type'] === 'deduct') {
                            $data['points'] = -abs($data['points']);
                        } else {
                            $data['points'] = abs($data['points']);
                        }
                        unset($data['points_type']);

                        return $livewire->getOwnerRecord()->points()->create(array_merge($data, ['business_id' => Auth::id()]));
                    }),
                Tables\Actions\Action::make('assign_points')
                    ->label('Assign Existing Points')
                    ->icon('heroicon-o-link')
                    ->form([
                        Forms\Components\Select::make('point_ids')
                            ->label('Unassigned Points')
                            ->options(function () {
                                return Point::where('business_id', Auth::id())
                                    ->whereNull('customer_id')
                                    ->get()
                                    ->mapWithKeys(function ($point) {
                                        $pointsType = $point->points >= 0 ? '+' : '-';
                                        return [
                                            $point->id => "ID: {$point->id} | Points: {$pointsType}" . abs($point->points) .
                                                " | {$point->description} ({$point->created_at->format('Y-m-d')})"
                                        ];
                                    });
                            })
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->helperText('Select one or more unassigned point transactions to assign to this customer'),
                    ])
                    ->action(function (array $data, RelationManager $livewire): void {
                        // Get the customer
                        $customer = $livewire->getOwnerRecord();

                        // Update the customer_id for each selected transaction
                        Point::whereIn('id', $data['point_ids'])
                            ->update(['customer_id' => $customer->id]);
                    })
                    ->successNotificationTitle('Point Transactions assigned successfully'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data, Point $record): array {
                        // Set the points_type based on the current points value
                        $data['points_type'] = $record->points >= 0 ? 'add' : 'deduct';
                        $data['points'] = abs($record->points);
                        return $data;
                    })
                    ->using(function (Point $record, array $data): Point {
                        // Handle add/deduct points toggle
                        if ($data['points_type'] === 'deduct') {
                            $data['points'] = -abs($data['points']);
                        } else {
                            $data['points'] = abs($data['points']);
                        }
                        unset($data['points_type']);

                        $record->update($data);
                        return $record->refresh();
                    }),
                // Tables\Actions\DetachAction::make(),
                Tables\Actions\Action::make('unassign')
                    ->label('Unassign')
                    ->icon('heroicon-o-x-mark')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Unassign Point Transaction')
                    ->modalDescription('This will remove the association between this transaction and the customer, but keep the transaction as unassigned.')
                    ->modalSubmitActionLabel('Unassign')
                    ->action(function (Point $record): void {
                        $record->update(['customer_id' => null]);
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
