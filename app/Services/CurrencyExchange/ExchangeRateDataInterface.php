<?php

namespace App\Services\CurrencyExchange;

interface ExchangeRateDataInterface
{
    public function getRates(): array;
}
