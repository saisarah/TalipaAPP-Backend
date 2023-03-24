<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Support\Str;

class PaymentTransaction extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';

    protected $keyType = 'string';

    protected $guarded = [];

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deposit(): void
    {
        if ($this->isPaid()) return;

        if (!$this->checkStatus("succeeded")) {
            Log::channel("wallet")->error("Payment Intent is still pending", [$this]);
            return;
        }

        DB::transaction(function() {
            $this->user->deposit($this->amount);
            $this->update([
                'status' => PaymentTransaction::STATUS_PAID
            ]);
        });

        Log::channel('wallet')->info("Payment Deposited Successfully", [$this]);
    }

    public function checkStatus($status)
    {
        $id = Str::of($this->id);
        if ($id->startsWith("paymongo")) {
            $paymentIntent = Paymongo::paymentIntent()->find($id->remove("paymongo_"));
            Log::info("status",[$paymentIntent->status]);
            return $paymentIntent->status === $status;
        }
        return false;
    }


}
