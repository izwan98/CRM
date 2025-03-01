<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Actions;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CustomerResource;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['business_id'] = auth()->id();

        return $data;
    }
}
