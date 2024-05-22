<?php

namespace App\Http\Requests\API\V1\ExchangeRateController;

use Illuminate\Foundation\Http\FormRequest;

class DoExchangeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'source' => 'required|string',
            'target' => 'required|string',
            'amount' => [
                'required',
                function (string $attribute, mixed $value, \Closure $fail) {
                    // 移除分隔符號
                    $value = str_replace(',', '', $value);
                    if (!is_numeric($value) || $value < 0) {
                        $fail("非有效的金額");
                    }
                },
            ]
        ];
    }
}
