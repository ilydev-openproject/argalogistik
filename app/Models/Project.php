<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\ClientPayment;
use App\Models\WeeklyPayment;
use App\Models\MaterialTransaction;
use App\Models\MaterialTransactionItem;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_name',
        'client_address',
        'name',
        'location',
        'total_rab',
    ];
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_employee', 'project_id', 'employee_id');
    }


    public function clientPayments()
    {
        return $this->hasMany(ClientPayment::class);
    }

    public function weeklyPayments()
    {
        return $this->hasMany(WeeklyPayment::class);
    }

    public function materialTransactions()
    {
        return $this->hasMany(MaterialTransaction::class);
    }
    public function materialTransactionItems()
    {
        return $this->hasManyThrough(
            MaterialTransactionItem::class,
            MaterialTransaction::class,
            'project_id', // Foreign key di material_transactions
            'material_transaction_id', // Foreign key di items
            'id', // Local key di projects
            'id'  // Local key di material_transactions
        );
    }

    public function getWeekNumber(Carbon $date): int
    {
        // Cari absensi pertama
        $firstAttendance = $this->attendances()
            ->orderBy('date', 'asc')
            ->first();

        // Cari pembayaran pertama
        $firstPayment = $this->weeklyPayments()
            ->orderBy('paid_date', 'asc')
            ->first();

        // Tentukan tanggal acuan
        $firstDate = $firstAttendance?->date
            ?? $firstPayment?->paid_date
            ?? $this->created_at;

        // Hitung selisih minggu
        return $date->startOfWeek(Carbon::MONDAY)->weekOfYear
            - Carbon::parse($firstDate)->startOfWeek(Carbon::MONDAY)->weekOfYear
            + 1;
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
