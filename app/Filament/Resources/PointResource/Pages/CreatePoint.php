<?php

namespace App\Filament\Resources\PointResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\PointResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePoint extends CreateRecord
{
    protected static string $resource = PointResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['points_type'] === 'deduct') {
            $data['points'] = -abs($data['points']);
        } else {
            $data['points'] = abs($data['points']);
        }
        unset($data['points_type']);

        return (array_merge($data, ['business_id' => Auth::id()]));
    }
}
