<?php

namespace App\Services\Wallet;

use App\Models\Transaction;
use App\Models\User;
use App\Services\Wallet\Exceptions\InsufficientBalanceException;
use App\Services\Wallet\Exceptions\NoWalletException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

trait HasWallet
{
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    public function activateWallet()
    {
        if (!$this->hasWallet()) {
            $this->wallet()->create();
        }

        return $this;
    }

    public function hasWallet(): bool
    {
        return $this->wallet()->exists();
    }

    public function hasSufficientBalance(float $amount): bool
    {
        return $this->wallet()->where('balance', '>=', $amount)->exists();
    }

    public function transferMoney(User $receiver, float $amount)
    {
        if (!$this->hasWallet()) throw new NoWalletException($this);
        if (!$receiver->hasWallet()) throw new NoWalletException($receiver);
        if (!$this->hasSufficientBalance($amount)) throw new InsufficientBalanceException($this);

        DB::transaction(function () use ($amount, $receiver) {
            $this->wallet()->decrement('balance', $amount);
            $receiver->wallet()->increment('balance', $amount);
        });

        return $this;
    }

    public function checkBalance(): float
    {
        return $this->wallet()->first()?->balance ?: 0;
    }
    

    public function usableBalance(): float
    {
        $wallet = $this->wallet()->first();
        return $wallet->balance - $wallet->locked;
    }

    public function deposit(float $amount)
    {
        if (!$this->hasWallet()) throw new NoWalletException($this);
        $this->wallet()->increment('balance', $amount);
        $this->transactions()->create([
            'amount' => $amount,
            'type' => Transaction::TYPE_CASH_IN,
        ]);
        return $this;
    }

    public function withdraw(float $amount)
    {
        if (!$this->hasWallet()) throw new NoWalletException($this);
        if (!$this->hasSufficientBalance($amount)) throw new InsufficientBalanceException($this);
        $this->wallet()->decrement('balance', $amount);
        return $this;
    }
}
