<?php

namespace App\Filament\Resources\ClientPayments\Pages;

use App\Filament\Resources\ClientPayments\ClientPaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClientPayment extends EditRecord
{
    protected static string $resource = ClientPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
