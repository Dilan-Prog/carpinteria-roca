<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'created_by',
        'assigned_to',
        'client_name',
        'client_phone',
        'product_description',
        'total_cost',
        'advance_payment',
        'remaining_balance',
        'estimated_delivery',
        'status',
        'cancelled_at',
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'advance_payment' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'estimated_delivery' => 'date',
        'cancelled_at' => 'datetime',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function productionStages(): HasMany
    {
        return $this->hasMany(ProductionStage::class);
    }

    public function canBeEdited(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $armadoFinished = $this->relationLoaded('productionStages')
            ? $this->productionStages
                ->where('stage', 'armado')
                ->where('state', 'terminado')
                ->isNotEmpty()
            : $this->productionStages()
                ->where('stage', 'armado')
                ->where('state', 'terminado')
                ->exists();

        return !$armadoFinished;
    }

    public function canBeCancelled(): bool
    {
        if ($this->status !== 'active' || !$this->created_at) {
            return false;
        }

        return $this->created_at->diffInHours(now()) < 48;
    }
}
