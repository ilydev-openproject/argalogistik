<?php

namespace App\Filament\Resources\ClientPayments\Pages;

use App\Filament\Resources\ClientPayments\ClientPaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClientPayment extends CreateRecord
{
    protected static string $resource = ClientPaymentResource::class;
}
