<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Depends;
use Tests\TestCase;

class QuoteApiTest extends TestCase
{
    public function testQuoteEndpointReturns401(): void
    {
        $resp = $this->get('/api/quotes');

        $resp->assertStatus(401);
    }

    public function testQuoteEndpointAuthReturns5KanyeQuotes(): array
    {
        $resp = $this->get('/api/quotes', ['Authorization' => 'Bearer ' . config('auth.api_token')]);
        $resp->assertStatus(200)
            ->assertJsonStructure(['data' => []]);
        $respData = $resp->json("data");

        $this->assertIsArray($respData);
        $this->assertCount(5, $respData);

        return $respData;
    }

    #[Depends("testQuoteEndpointAuthReturns5KanyeQuotes")]
    public function test_quote_refresh_endpoint_returns_5_new_kanye_quotes($prevResp): void
    {

        $resp = $this->get('/api/quotes/refresh', ['Authorization' => 'Bearer ' . config('auth.api_token')]);
        $resp->assertStatus(200)
            ->assertJsonStructure(['data' => []]);
        $respData = $resp->json("data");

        $this->assertIsArray($respData);
        $this->assertCount(5, $respData);
        $this->assertNotEquals($prevResp, $respData);
    }
}
