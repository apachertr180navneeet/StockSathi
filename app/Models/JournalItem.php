<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_id',
        'account_id',
        'debit',
        'credit',
        'description',
    ];

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    protected static function booted()
    {
        static::created(function ($item) {
            $item->account->recalculateBalance();
        });

        static::updated(function ($item) {
            $item->account->recalculateBalance();
        });

        static::deleted(function ($item) {
            $item->account->recalculateBalance();
        });
    }
}
