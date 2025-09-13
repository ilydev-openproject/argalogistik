<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTransactionItem extends Model
{
    protected $fillable = [
        'material_transaction_id',
        'item_description',
        'unit',
        'quantity',
        'unit_price',
        'discount_amount',
        'total_price',
    ];

    public function transaction()
    {
        return $this->belongsTo(MaterialTransaction::class, 'material_transaction_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
