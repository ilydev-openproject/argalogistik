<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    protected $fillable = [
        'project_id',
        'step',
        'amount',
        'paid_date',
        'proof_of_transfer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
