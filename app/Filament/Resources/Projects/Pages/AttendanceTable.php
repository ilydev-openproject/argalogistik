<?php

namespace App\Filament\Resources\Projects\Pages;

use Carbon\Carbon;
use App\Models\Project;
use Filament\Actions\Action;
use App\Models\WeeklyPayment;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Schemas\Components\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Forms\Components\Placeholder;
use App\Models\Attendance as AttendanceModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Filament\Resources\Projects\ProjectResource;

class AttendanceTable extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.attendance-table';

    public Project $project;
    public ?array $attendanceData = [];
    public ?float $totalAllowance = 0;
    public ?float $totalAdvance = 0;
    public ?Carbon $startOfWeek = null;
    public ?Carbon $endOfWeek = null;
    public ?string $selectedDate = null;
    public ?int $weekNumber = null;
    private array $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    public function mount(int|string $record): void
    {
        $this->project = Project::find($record);
        $this->startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $this->endOfWeek = now()->endOfWeek(Carbon::SATURDAY);
        $this->loadAttendanceData();
    }

    public function updatedSelectedDate($value): void
    {
        if ($value) {
            $this->startOfWeek = Carbon::parse($value)->startOfWeek(Carbon::MONDAY);
            $this->endOfWeek = Carbon::parse($value)->endOfWeek(Carbon::SATURDAY);
            $this->loadAttendanceData();
        }
    }

    public function previousWeek(): void
    {
        $this->startOfWeek = $this->startOfWeek->subWeek();
        $this->endOfWeek = $this->startOfWeek->clone()->endOfWeek(Carbon::SATURDAY);
        $this->loadAttendanceData();
    }

    public function nextWeek(): void
    {
        $this->startOfWeek = $this->startOfWeek->addWeek();
        $this->endOfWeek = $this->startOfWeek->clone()->endOfWeek(Carbon::SATURDAY);
        $this->loadAttendanceData();
    }

    public function loadAttendanceData(): void
    {
        $employees = $this->project->employees;
        $existingAttendance = AttendanceModel::where('project_id', $this->project->id)
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
                        $dayName = $this->days[$dayIndex - 1];
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

        $weeklyPayment = WeeklyPayment::where('project_id', $this->project->id)
            ->whereBetween('paid_date', [$this->startOfWeek, $this->endOfWeek])
            ->first();
        if ($weeklyPayment) {
            $this->totalAllowance = $weeklyPayment->total_allowance;
            $this->totalAdvance = $weeklyPayment->total_advance;
            $this->weekNumber = $weeklyPayment->week_number;
        } else {
            $this->totalAllowance = 0;
            $this->totalAdvance = 0;
            $this->weekNumber = $this->project->getWeekNumber($this->startOfWeek);

        }
    }

    public function getTotalWages(): array
    {
        return collect($this->attendanceData)->map(function ($record) {
            $totalDays = 0;
            $overtimeHours = $record['lembur'] ?? 0;
            $upahHarian = $record['upah_harian'] ?? 0;

            foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $day) {
                $totalDays += $record[$day] ?? 0;
            }

            $totalLembur = ($upahHarian / 8) * $overtimeHours;
            $totalUpah = ($totalDays * $upahHarian) + $totalLembur;

            return [
                'total_upah' => $totalUpah,
            ];
        })->toArray();
    }

    public function getTotalSalary(): float
    {
        $totalWages = collect($this->getTotalWages())->sum('total_upah');
        return $totalWages + $this->totalAllowance - $this->totalAdvance;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(fn(): string => ProjectResource::getUrl('edit', ['record' => $this->project->id]))
                ->color('gray')
        ];
    }

    public function submit(): void
    {
        $employeesAttendance = $this->attendanceData;

        DB::beginTransaction();

        try {
            AttendanceModel::where('project_id', $this->project->id)
                ->whereBetween('date', [$this->startOfWeek, $this->endOfWeek])
                ->delete();

            foreach ($employeesAttendance as $record) {
                foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $day) {
                    if (!is_null($record[$day])) {
                        AttendanceModel::create([
                            'project_id' => $this->project->id,
                            'employee_id' => $record['employee_id'],
                            'date' => $this->startOfWeek->clone()->addDays(array_search($day, ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'])),
                            'status' => ($record[$day] == 1) ? 'Hadir Penuh' : (($record[$day] == 0.5) ? 'Setengah Hari' : 'Tidak Hadir'),
                            'overtime_hours' => $record['lembur'] ?? 0,
                        ]);
                    }
                }
            }

            WeeklyPayment::updateOrCreate(
                [
                    'project_id' => $this->project->id,
                    'week_number' => $this->weekNumber,
                ],
                [
                    'paid_date' => $this->endOfWeek,
                    'paid_amount' => $this->getTotalSalary(),
                    'total_allowance' => $this->totalAllowance,
                    'total_advance' => $this->totalAdvance,
                ]
            );


            DB::commit();

            Notification::make()
                ->title('Absensi & Gaji berhasil disimpan!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            DB::rollBack();

            Notification::make()
                ->title('Terjadi kesalahan saat menyimpan absensi & gaji.')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
    public function openPayslip(): void
    {
        redirect()->to(ProjectResource::getUrl('payslip', [
            'record' => $this->project->id,
            'startOfWeek' => $this->startOfWeek->format('Y-m-d')
        ]));
    }
}
