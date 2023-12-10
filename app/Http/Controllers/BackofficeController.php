<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MerchantGetIncomeRequest;
use App\Http\Resources\TimeRange;
use App\Services\BackofficeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class BackofficeController extends Controller
{
    public function __construct(private readonly BackofficeService $backofficeService)
    {
    }

    public function getIncome(MerchantGetIncomeRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        $timeRange = new TimeRange($requestData['timeRange']['start'], $requestData['timeRange']['end']);
        $income = $this->backofficeService->getIncome($timeRange);

        return response()->json($income, $income->isNotEmpty() ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }
}
