<?php

namespace App\Filament\Resources\ClientPayments;

use UnitEnum;
use App\Filament\Resources\ClientPayments\Pages\ListClientPayments;
use App\Filament\Resources\ClientPayments\Schemas\ClientPaymentForm;
use App\Filament\Resources\ClientPayments\Tables\ClientPaymentsTable;
use App\Models\ClientPayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientPaymentResource extends Resource
{
    protected static ?string $model = ClientPayment::class;
    protected static string|UnitEnum|null $navigationGroup = 'Klien';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $modelLabel = 'Pembayaran Klien';

    protected static ?string $recordTitleAttribute = 'Pembayaran Klien';

    public static function form(Schema $schema): Schema
    {
        return ClientPaymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientPaymentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientPayments::route('/'),
            // 'create' => CreateClientPayment::route('/create'),
            // 'edit' => EditClientPayment::route('/{record}/edit'),
        ];
    }
}
