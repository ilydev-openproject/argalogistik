<?php

namespace App\Filament\Resources\MaterialTransactionItems;

use App\Filament\Resources\MaterialTransactionItems\Pages\CreateMaterialTransactionItem;
use App\Filament\Resources\MaterialTransactionItems\Pages\EditMaterialTransactionItem;
use App\Filament\Resources\MaterialTransactionItems\Pages\ListMaterialTransactionItems;
use App\Filament\Resources\MaterialTransactionItems\Schemas\MaterialTransactionItemForm;
use App\Filament\Resources\MaterialTransactionItems\Tables\MaterialTransactionItemsTable;
use App\Models\MaterialTransactionItem;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaterialTransactionItemResource extends Resource
{
    protected static ?string $model = MaterialTransactionItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;
    protected static string|UnitEnum|null $navigationGroup = 'Material';
    protected static ?string $modelLabel = 'Logistik Item';
    protected static ?string $pluralModelLabel = 'Logistik Item';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'MaterialTransactionItem';

    public static function form(Schema $schema): Schema
    {
        return MaterialTransactionItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialTransactionItemsTable::configure($table);
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
            'index' => ListMaterialTransactionItems::route('/'),
            // 'create' => CreateMaterialTransactionItem::route('/create'),
            // 'edit' => EditMaterialTransactionItem::route('/{record}/edit'),
        ];
    }
}
