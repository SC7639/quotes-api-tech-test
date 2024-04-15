<?php

declare(strict_types=1);

namespace App\DataProviders;

use App\DataTransferObjects\QuoteData;
use Illuminate\Support\Collection;

class NullObjectQuoteProvider implements QuoteProvider
{
    public function getQuotes(?int $numQuotes): Collection
    {
        return collect([
            new QuoteData('')
        ]);
    }
}
