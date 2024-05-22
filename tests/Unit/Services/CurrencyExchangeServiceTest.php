<?php

namespace Tests\Unit\Services;

use App\Services\CurrencyExchange\ConcreteExchangeRateData;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeServiceTest extends TestCase
{
    public function test_throws_exception_for_invalid_currency_code()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('找不到貨幣可轉換');

        $rateData = \Mockery::mock(ConcreteExchangeRateData::class);
        $rateData->shouldReceive('getRates')
            ->andReturn([
                'currencies' => [
                    'USD' => ['USD' => 1, 'JPY' => 111.801],
                    'JPY' => ['USD' => 0.00885, 'JPY' => 1],
                ]
            ]);

        $service = new CurrencyExchangeService($rateData);

        $service->convert('INVALID', 'JPY', 1000);
    }

    public function test_throws_exception_for_amount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('金額為非數字');

        $rateData = \Mockery::mock(ConcreteExchangeRateData::class);
        $rateData->shouldReceive('getRates')
            ->andReturn([
                'currencies' => [
                    'USD' => ['USD' => 1, 'JPY' => 111.801],
                    'JPY' => ['USD' => 0.00885, 'JPY' => 1],
                ]
            ]);

        $service = new CurrencyExchangeService($rateData);

        $service->convert('USD', 'JPY', '不是數字');
    }

    #[DataProvider('amountProvider')]
    public function test_convert_result($amount, $result)
    {
        $rateData = \Mockery::mock(ConcreteExchangeRateData::class);
        $rateData->shouldReceive('getRates')
            ->andReturn([
                'currencies' => [
                    'USD' => ['USD' => 1, 'JPY' => 111.801],
                    'JPY' => ['USD' => 0.00885, 'JPY' => 1],
                ]
            ]);

        $service = new CurrencyExchangeService($rateData);
        $act = $service->convert('USD', 'JPY', $amount);

        $this->assertEquals($result, $act);
    }

    public static function amountProvider(): array
    {
        return [
            [1525.678, 170572.55], // 小數位數超過2位
            [1525, 170496.53], // 沒小數點
            [0, 0], // 放入0試試
        ];
    }
}
