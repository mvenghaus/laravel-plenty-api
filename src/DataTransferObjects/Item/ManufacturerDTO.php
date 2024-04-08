<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\DataTransferObjects\Item;

use Illuminate\Support\Carbon;

final readonly class ManufacturerDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public array $names,
        public Carbon $updatedAt
    ) {
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            id: $data['id'],
            name: $data['name'],
            names: json_decode(!empty($data['comment']) ? trim($data['comment'], ' "') : '[]', true),
            updatedAt: Carbon::parse($data['updatedAt'])
        );
    }
}