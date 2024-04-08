<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\DataTransferObjects\V2;

use Illuminate\Support\Carbon;
use Mvenghaus\PlentyApi\DataTransferObjects\V2\Property\SelectionDTO;

final readonly class PropertyDTO
{
    public function __construct(
        public int $id,
        public string $cast,
        public string $type,
        public array $names,
        public Carbon $updatedAt,
        public Carbon $createdAt,
        public array $selections = []
    ) {
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            id: $data['id'],
            cast: $data['cast'],
            type: $data['type'],
            names: collect($data['names'])
                ->mapWithKeys(fn(array $nameData) => [$nameData['lang'] => $nameData['name']])
                ->all(),
            updatedAt: Carbon::parse($data['updatedAt']),
            createdAt: Carbon::parse($data['createdAt']),
            selections: collect($data['selections'])
                ->map(fn(array $selectionData) => SelectionDTO::fromResponse($selectionData))
                ->all()
        );
    }
}