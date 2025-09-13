<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPayment extends Model
{
    protected $fillable = [
        'project_id',
        'week_number',
        'paid_date',
        'paid_amount',
        'total_allowance',
        'total_advance',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
