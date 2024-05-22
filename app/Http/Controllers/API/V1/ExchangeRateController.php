<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\ExchangeRateController\DoExchangeRequest;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use Illuminate\Http\JsonResponse;

class ExchangeRateController extends Controller
{
    protected $currencyExchangeService;

    public function __construct(CurrencyExchangeService $currencyExchangeService)
    {
        $this->currencyExchangeService = $currencyExchangeService;
    }
    public function doExchange(DoExchangeRequest $request): JsonResponse
    {
        $params = $request->validated();
        $convertedAmount = $this->currencyExchangeService->convert($params['source'], $params['target'], $params['amount']);

        return response()->json([
            "msg" => "success",
            // 格式化結果，使其包含千分位分隔符
            "amount" => number_format($convertedAmount, 2),
        ]);
    }
}
