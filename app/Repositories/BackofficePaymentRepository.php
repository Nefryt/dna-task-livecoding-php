<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\TimeRange;
use App\Models\Payment;
use Illuminate\Support\Collection;

class BackofficePaymentRepository implements BackofficePaymentRepositoryInterface
{
    public function getIncomeByMerchantWithTimeRange(TimeRange $timeRange): Collection
    {
        return Payment::groupBy('payments.merchantId')
            ->selectRaw('SUM(payments.amount) as income, payments.merchantId, merchants.name')
            ->join('merchants', 'merchants.merchantId', '=', 'payments.merchantId')
            ->whereBetween('payments.created_at', [$timeRange->getStart(), $timeRange->getEnd()])
            ->get();
    }
}
