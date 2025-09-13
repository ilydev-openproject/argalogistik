<?php

namespace App\Filament\Resources\Projects\Pages;

use Carbon\Carbon;
use App\Models\Project;
use Filament\Actions\Action;
use App\Models\Attendance;
use App\Models\WeeklyPayment;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\Projects\ProjectResource;

class PaySlip extends Page
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.pay-slip';

    public Project $project;
    public ?array $attendanceData = [];
    public ?array $totalWages = [];
    public ?Carbon $startOfWeek;
    public ?Carbon $endOfWeek;
    public ?WeeklyPayment $weeklyPayment;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(fn(): string => ProjectResource::getUrl('attendance', [
                    'record' => $this->project->id
                ]))
                ->color('gray')
        ];
    }

    public function mount(int|string $record): void
    {
        $this->project = Project::find($record);

        // Mengambil parameter startOfWeek dari request query
        $startOfWeek = request()->query('startOfWeek');
        $this->startOfWeek = Carbon::parse($startOfWeek);
        $this->endOfWeek = $this->startOfWeek->clone()->endOfWeek(Carbon::SATURDAY);

        $this->loadAttendanceData();

        $this->weeklyPayment = WeeklyPayment::where('project_id', $this->project->id)
            ->whereBetween('paid_date', [$this->startOfWeek, $this->endOfWeek])
            ->first();
    }

    public function loadAttendanceData(): void
    {
        $employees = $this->project->employees;
        $existingAttendance = Attendance::where('project_id', $this->project->id)
            ->whereBetween('date', [$this->startOfWeek, $this->endOfWeek])
            ->get()
            ->groupBy('employee_id');

        $this->attendanceData = $employees->map(function ($employee) use ($existingAttendance) {
            $data = [
                'employee_id' => $employee->id,
                'name' => $employee->name,
                'role' => $employee->role,
                'upah_harian' => $employee->upah_harian,
                'senin' => null,
                'selasa' => null,
                'rabu' => null,
                'kamis' => null,
                'jumat' => null,
                'sabtu' => null,
                'lembur' => 0,
            ];

            if ($existingAttendance->has($employee->id)) {
                $employeeRecords = $existingAttendance->get($employee->id);
                foreach ($employeeRecords as $record) {
                    $dayIndex = Carbon::parse($record->date)->dayOfWeek;
                    if ($dayIndex > 0 && $dayIndex < 7) {
                        $dayName = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'][$dayIndex - 1];
                        if ($record->status == 'Hadir Penuh') {
                            $data[$dayName] = 1;
                        } elseif ($record->status == 'Setengah Hari') {
                            $data[$dayName] = 0.5;
                        }
                    }
                    $data['lembur'] = $record->overtime_hours;
                }
            }
            return $data;
        })->toArray();

        $this->totalWages = collect($this->attendanceData)->map(function ($record) {
            $totalDays = 0;
            $overtimeHours = $record['lembur'] ?? 0;
            $upahHarian = $record['upah_harian'] ?? 0;

            foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $day) {
                $totalDays += $record[$day] ?? 0;
            }

            $totalLembur = ($upahHarian / 8) * $overtimeHours;
            $totalUpah = ($totalDays * $upahHarian) + $totalLembur;

            return ['total_upah' => $totalUpah];
        })->toArray();
    }
}
