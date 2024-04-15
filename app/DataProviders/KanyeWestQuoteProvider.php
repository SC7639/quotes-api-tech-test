<?php

declare (strict_types=1);

namespace App\DataProviders;

use App\DataTransferObjects\QuoteData;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class KanyeWestQuoteProvider implements QuoteProvider
{
    public function getQuotes(int $numQuotes = 5, bool $forceNew = false): Collection
    {

        if (!$forceNew) {
            $cachedQuotes = $this->getCachedQuotes($numQuotes);
            if (!is_null($cachedQuotes)) {
                $numCachedQuotes = count($cachedQuotes);
                if ($numCachedQuotes < $numQuotes) { // Get more quotes is not enough in cache
                    $quotesNeeded = $numQuotes - $numCachedQuotes;
                    $extraQuotes = $this->doRequest($quotesNeeded);
                    $cachedQuotes = $cachedQuotes->merge($extraQuotes);
                    $this->storeQuotes($cachedQuotes);
                }
                return $cachedQuotes;
            }
        }

        $quotes = $this->doRequest($numQuotes);
        $this->storeQuotes($quotes);
        return $quotes;
    }



    private function getCachedQuotes(int $numQuotes): Collection | null
    {
        $storedQuotesJson = Cache::get('quotes');
        if (!$storedQuotesJson) {
            return null;
        }
        return collect(json_decode($storedQuotesJson))
            ->slice(0, $numQuotes);
    }

    private function storeQuotes(Collection $quotes)
    {
        Cache::set('quotes', $quotes->toJson());
    }

    private function doRequest(int $numQuotes): Collection
    {
        $baseUrl = config('external-apis.kanye-west.base_url');

        // Use guzzle to get quotes in parallel
        try {
            $client = new Client();
            $promises = [];
            for ($i = 0; $i < $numQuotes; $i++) {
                $promises[] = $client->getAsync($baseUrl);
            }

            $results = Utils::settle($promises)->wait();
            return collect($results)->map(function ($result) {
                ['value' => $resp] = $result;
                $bodyContents = $resp->getBody()->getContents();
                $data = json_decode($bodyContents, true);
                return $data['quote'] ?? '';
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return Collection::make();
        }
    }
}
