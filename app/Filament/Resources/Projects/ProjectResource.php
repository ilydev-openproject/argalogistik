<?php

namespace App\Filament\Resources\Projects;

use UnitEnum;
use BackedEnum;
use App\Models\Project;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Filament\Resources\Projects\Tables\ProjectsTable;
use App\Filament\Resources\Projects\RelationManagers\EmployeesRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ClientPaymentsRelationManager;
use App\Filament\Resources\Projects\RelationManagers\MaterialTransactionsRelationManager;
use App\Filament\Resources\Projects\RelationManagers\MaterialTransactionItemRelationManager;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static string|UnitEnum|null $navigationGroup = 'Mater Data';
    protected static ?int $navigationSort = 1;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'Project';

    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ClientPaymentsRelationManager::class,
            EmployeesRelationManager::class,
            MaterialTransactionsRelationManager::class,
            MaterialTransactionItemRelationManager::class,
            // AttendanceTable::class,
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
            'summary' => Pages\Summary::route('/{record}/summary'),
            'attendance' => Pages\AttendanceTable::route('/{record}/attendance'),
            'payslip' => Pages\Payslip::route('/{record}/payslip'),
        ];
    }
}
