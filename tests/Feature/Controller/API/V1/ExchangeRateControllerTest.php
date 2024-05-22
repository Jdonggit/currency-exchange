<?php

namespace Tests\Feature\Controller\API\V1;

use Tests\TestCase;

class ExchangeRateControllerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_ok(): void
    {
        // act
        $response = $this->getJson(route('api.exchange').'?'.http_build_query([
            'source' => 'USD',
            'target' => 'JPY',
            'amount' => '1,525'
        ]));

        $response->assertOk()
            ->assertJson([
                'msg' => 'success',
                'amount' => '170,496.53'
            ]);
    }
}
