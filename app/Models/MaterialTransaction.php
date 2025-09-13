<?php

namespace App\Models;

use App\Models\MaterialTransactionItem;
use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    protected $fillable = [
        'project_id',
        'transaction_date',
        'store_name',
        'notes',
        'receipt_photo',
    ];
    protected $casts = [
        'transaction_date' => 'date',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(MaterialTransactionItem::class, 'material_transaction_id');
    }

}
