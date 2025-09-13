<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Models\Project;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\Projects\ProjectResource;

class Summary extends Page
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.summary';
    public Project $project;
    public $totalIncoming;
    public $totalLogistics;
    public $totalLabor;
    public $totalExpenses;
    public $profitMargin;
    public $logisticsPercentage;
    public $laborPercentage;

    public function mount(int|string $record): void
    {
        $this->project = Project::findOrFail($record);

        // Total uang masuk dari klien
        $this->totalIncoming = $this->project->clientPayments()->sum('amount');

        // Total pengeluaran logistik dari semua item
        $this->totalLogistics = $this->project
            ->materialTransactionItems() // pastikan relasi hasManyThrough di Project model
            ->sum('total_price');

        // Total pengeluaran untuk tenaga kerja
        $this->totalLabor = $this->project->weeklyPayments()->sum('paid_amount');

        // Total semua pengeluaran
        $this->totalExpenses = $this->totalLogistics + $this->totalLabor;

        // Margin Keuntungan
        $this->profitMargin = $this->totalIncoming - $this->totalExpenses;

        // Persentase terhadap total RAB
        $this->logisticsPercentage = ($this->project->total_rab > 0)
            ? ($this->totalLogistics / $this->project->total_rab) * 100
            : 0;

        $this->laborPercentage = ($this->project->total_rab > 0)
            ? ($this->totalLabor / $this->project->total_rab) * 100
            : 0;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(fn(): string => ProjectResource::getUrl('edit', ['record' => $this->project->id]))
                ->color('gray'),
        ];
    }
}

