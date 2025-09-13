<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'project_id',
        'employee_id',
        'date',
        'status',
        'overtime_hours',
    ];
    protected $casts = [
        'date' => 'datetime',
        'overtime_hours' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
