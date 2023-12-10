<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Resources\TimeRange;
use App\Repositories\BackofficePaymentRepositoryInterface;
use App\Services\BackofficeService;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class BackofficeServiceTest extends TestCase
{
    public function testGetIncome(): void
    {
        $payments = Collection::make([
            [
                'income' => 11,
                'merchantId' => '777724f5-ec0d-4636-80ed-0d8a9f1faac6',
                'name' => 'Test Merchant 1',
            ],
            [
                'income' => 121,
                'merchantId' => '777724f5-ec0d-4736-80ed-0d8a9f1faac6',
                'name' => 'Test Merchant 2',
            ]
        ]);

        /** @var MockInterface&BackofficePaymentRepositoryInterface $paymentRepository */
        $paymentRepository = $this
            ->mock(BackofficePaymentRepositoryInterface::class, function (MockInterface $mock) use ($payments) {
                $mock->shouldReceive('getIncomeByMerchantWithTimeRange')->once()
                    ->andReturn($payments);
            });

        $sut = new BackofficeService($paymentRepository);

        /** @var MockInterface&TimeRange $timeRange */
        $timeRange = $this->mock(TimeRange::class);
        $result = $sut->getIncome($timeRange);

        self::assertNotEmpty($result);
        self::assertNotNull($result);
        self::assertIsIterable($result);
        self::assertSame($payments, $result);
        self::assertArrayHasKey('income', $result->first());
        self::assertArrayHasKey('merchantId', $result->first());
        self::assertArrayHasKey('name', $result->first());
    }

    public function testGetEmptyIncome(): void
    {
        /** @var MockInterface&BackofficePaymentRepositoryInterface $paymentRepository */
        $paymentRepository = $this
            ->mock(BackofficePaymentRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('getIncomeByMerchantWithTimeRange')->once()
                    ->andReturn(Collection::empty());
            });

        $sut = new BackofficeService($paymentRepository);

        /** @var MockInterface&TimeRange $timeRange */
        $timeRange = $this->mock(TimeRange::class);
        $result = $sut->getIncome($timeRange);

        self::assertEmpty($result);
    }
}
