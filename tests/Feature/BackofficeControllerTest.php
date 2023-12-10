<?php

declare(strict_types=1);

namespace Feature;

use Database\Seeders\BackofficeTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BackofficeControllerTest extends TestCase
{
    use RefreshDatabase;

    private const INCOME_API_URL = 'api/backoffice/income';
    private const TIME_FORMAT = 'Y-m-d H:i';

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(BackofficeTestSeeder::class);
    }

    public static function getIncomeDataProvider(): array
    {
        return [
            [
                1,
                [
                    ['income' => 10, 'merchantId' => 'mid123', 'name' => 'Merchant 1'],
                    ['income' => 30, 'merchantId' => 'mid456', 'name' => 'Merchant 2'],
                ],
            ],
            [
                2,
                [
                    ['income' => 10, 'merchantId' => 'mid123', 'name' => 'Merchant 1'],
                    ['income' => 90, 'merchantId' => 'mid456', 'name' => 'Merchant 2'],
                ]
            ]
        ];
    }

    /**
     * @dataProvider getIncomeDataProvider
     */
    public function testGetIncome(int $subDays, array $expected): void
    {
        $start = Carbon::now()->subDays($subDays)->format(self::TIME_FORMAT);
        $end = Carbon::now()->addDay()->format(self::TIME_FORMAT);

        $url = $this->prepareUrlWithParams($start, $end);

        $response = $this->json('GET', $url)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([['income', 'merchantId', 'name']]);
        self::assertSame($expected, $response->json());
    }

    public function testGetIncomeEmpty(): void
    {
        $start = Carbon::now()->addDay()->format(self::TIME_FORMAT);
        $end = Carbon::now()->addDays(2)->format(self::TIME_FORMAT);

        $url = $this->prepareUrlWithParams($start, $end);

        $this->json('GET', $url)
            ->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();
    }

    private function prepareUrlWithParams(string $start, string $end): string
    {
        return self::INCOME_API_URL . '?' . http_build_query(['timeRange' => ['start' => $start, 'end' => $end]]);
    }
}
