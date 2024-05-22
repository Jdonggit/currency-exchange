<?php
namespace App\Services\CurrencyExchange;
class CurrencyExchangeService
{
    protected $rates;

    public function __construct(ExchangeRateDataInterface $rates)
    {
        $this->rates = $rates;
    }

    /**
     * 進行貨幣轉換
     *
     * @param  string  $source
     * @param  string  $target
     * @param  float   $amount
     * @return float
     */
    public function convert(string $source, string $target, mixed $amount): float
    {
        $rates = $this->rates->getRates();
        if (!isset($rates['currencies'][$source][$target])) {
            throw new \InvalidArgumentException("找不到貨幣可轉換");
        }
        // 移除分隔符號
        $amount = str_replace(',', '', $amount);
        if (!is_numeric($amount) || $amount < 0) {
            throw new \InvalidArgumentException("金額為非數字");
        }
        // 輸入數字四捨五入到小數點兩位
        $amount = round($amount, 2);
        $rate = $rates['currencies'][$source][$target];
        return round($amount * $rate, 2);
    }
}
