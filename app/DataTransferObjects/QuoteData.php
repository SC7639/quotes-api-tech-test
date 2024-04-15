<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Transformation\TransformationContextFactory;
use Spatie\LaravelData\Support\Transformation\TransformationContext;

class QuoteData extends DataCollection
{
    public function __construct(private string $quote)
    {

    }
    public function transform(null|TransformationContextFactory|TransformationContext $transformationContext = null): array
    {
        return [
            'quote' => (string)$this->quote,
        ];
    }
}
