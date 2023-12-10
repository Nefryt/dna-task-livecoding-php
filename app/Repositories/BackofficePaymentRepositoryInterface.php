<?php

namespace App\Repositories;

use App\Http\Resources\TimeRange;
use Illuminate\Support\Collection;

interface BackofficePaymentRepositoryInterface
{
    public function getIncomeByMerchantWithTimeRange(TimeRange $timeRange): Collection;
}
