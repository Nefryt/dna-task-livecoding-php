<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\TimeRange;
use App\Repositories\BackofficePaymentRepositoryInterface;
use Illuminate\Support\Collection;

class BackofficeService
{
    public function __construct(private readonly BackofficePaymentRepositoryInterface $paymentRepository)
    {
    }

    public function getIncome(TimeRange $timeRange): Collection
    {
        return $this->paymentRepository->getIncomeByMerchantWithTimeRange($timeRange);
    }
}
