<?php

declare(strict_types=1);

namespace App\Providers;

use App\DataProviders\KanyeWestQuoteProvider;
use App\DataProviders\NullObjectQuoteProvider;
use App\DataProviders\QuoteProvider;
use Illuminate\Support\ServiceProvider;

class ExternalDataProvidersProvider extends ServiceProvider
{
    /**
     * Register application services
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QuoteProvider::class, fn ($app) => match(config('external-apis.quotesProvider')) {
            'kanye-west' => new KanyeWestQuoteProvider(),
            default => new NullObjectQuoteProvider(),
        });
    }
}
