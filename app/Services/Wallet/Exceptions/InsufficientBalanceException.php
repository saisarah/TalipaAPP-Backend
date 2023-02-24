<?php

namespace App\Services\Wallet\Exceptions;

use App\Models\User;

class InsufficientBalanceException extends \Exception
{
    public function __construct(
        private User $user
    ) {
        parent::__construct("{$user->username} has not enough sufficient balance.");
    }
}
