<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataProviders\QuoteProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct(protected QuoteProvider $quoteProvider)
    {

    }

    public function get(): array
    {
        $quoteData = $this->quoteProvider->getQuotes(5);
        return ['data' => $quoteData];
    }

    public function refresh(): array
    {
        $quoteData = $this->quoteProvider->getQuotes(5, true);
        return ['data' => $quoteData];
    }
}
