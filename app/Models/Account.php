<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'type',
        'parent_id',
        'is_system',
        'status',
        'description',
        'opening_balance',
        'current_balance',
    ];

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function journalItems()
    {
        return $this->hasMany(JournalItem::class);
    }

    /**
     * Recalculate the current balance based on journal items and opening balance.
     */
    public function recalculateBalance()
    {
        $totalDebit = $this->journalItems()->sum('debit');
        $totalCredit = $this->journalItems()->sum('credit');

        // Normal balances:
        // Asset/Expense: Debit increases, Credit decreases
        // Liability/Equity/Revenue: Credit increases, Debit decreases
        
        if (in_array($this->type, ['Asset', 'Expense'])) {
            $this->current_balance = $this->opening_balance + ($totalDebit - $totalCredit);
        } else {
            $this->current_balance = $this->opening_balance + ($totalCredit - $totalDebit);
        }

        $this->save();
    }
}
