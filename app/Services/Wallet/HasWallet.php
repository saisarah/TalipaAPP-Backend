<?php

namespace App\Services\Wallet;

use App\Models\User;
use App\Services\Wallet\Exceptions\InsufficientBalanceException;
use App\Services\Wallet\Exceptions\NoWalletException;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

trait HasWallet
{
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function activateWallet(): void
    {
        if (!$this->hasWallet()) {
            $this->wallet()->create();
        }
    }

    public function hasWallet(): bool
    {
        return $this->wallet()->exists();
    }

    public function hasSufficientBalance(float $amount): bool
    {
        return $this->wallet()->where('balance', '>=', $amount)->exists();
    }

    public function transferMoney(User $receiver, float $amount): void
    {
        if (!$this->hasWallet()) throw new NoWalletException($this);
        if (!$receiver->hasWallet()) throw new NoWalletException($receiver);
        if (!$this->hasSufficientBalance($amount)) throw new InsufficientBalanceException($this);

        DB::transaction(function () use ($amount, $receiver) {
            $this->wallet()->decrement('balance', $amount);
            $receiver->wallet()->increment('balance', $amount);
        });
    }

    public function checkBalance(): float
    {
        return $this->wallet()->first()?->balance ?: 0;
    }

    public function deposit(float $amount): void
    {
        $this->wallet()->increment('balance', $amount);
    }

    public function withdraw(float $amount): void
    {
        if (!$this->hasSufficientBalance($amount)) throw new InsufficientBalanceException($this);
        $this->wallet()->decrement('balance', $amount);
    }
}
