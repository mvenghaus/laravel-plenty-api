<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\DataTransferObjects\V2\Property;

use Illuminate\Support\Carbon;

final readonly class SelectionDTO
{
    public function __construct(
        public int $id,
        public int $propertyId,
        public int $position,
        public array $names,
        public Carbon $updatedAt,
        public Carbon $createdAt

    ) {
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            id: $data['id'],
            propertyId: $data['propertyId'],
            position: $data['position'],
            names: collect($data['names'])
                ->mapWithKeys(fn(array $nameData) => [$nameData['lang'] => $nameData['name']])
                ->all(),
            updatedAt: Carbon::parse($data['updatedAt']),
            createdAt: Carbon::parse($data['createdAt'])
        );
    }
}