<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\DataTransferObjects\Item;

use Illuminate\Support\Carbon;

final readonly class TextsDTO
{
    public function __construct(
        public array $names,
        public array $names2,
        public array $descriptions
    ) {
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            names: collect($data)
                ->mapWithKeys(fn(array $textData) => [$textData['lang'] => $textData['name']])
                ->all(),
            names2: collect($data)
                ->mapWithKeys(fn(array $textData) => [$textData['lang'] => $textData['name2']])
                ->all(),
            descriptions: collect($data)
                ->mapWithKeys(fn(array $textData) => [$textData['lang'] => $textData['description']])
                ->all(),
        );
    }
}