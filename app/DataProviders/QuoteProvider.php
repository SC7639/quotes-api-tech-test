<?php

declare(strict_types=1);

namespace App\DataProviders;

use Illuminate\Support\Collection;

interface QuoteProvider
{
    public function getQuotes(int $numQuotes): Collection;
}
