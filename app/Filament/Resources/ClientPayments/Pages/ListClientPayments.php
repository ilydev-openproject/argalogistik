<?php

namespace App\Filament\Resources\ClientPayments\Pages;

use App\Filament\Resources\ClientPayments\ClientPaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientPayments extends ListRecords
{
    protected static string $resource = ClientPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
