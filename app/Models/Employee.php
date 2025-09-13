<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'role',
        'upah_harian',
    ];
    protected $casts = [
        'upah_harian' => 'decimal:2',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employee', 'employee_id', 'project_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->name} - {$this->role}",
        );
    }
}
