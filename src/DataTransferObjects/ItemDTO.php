<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\DataTransferObjects;

use Illuminate\Support\Carbon;

final readonly class ItemDTO
{
    public function __construct(
        public int $id,
        public string $marking1,
        public string $marking2,
        public int $manufacturerId,
        public Carbon $updatedAt,
        public Carbon $createdAt,
    ) {
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            id: $data['id'],
            marking1: (string)$data['flagOne'],
            marking2: (string)$data['flagTwo'],
            manufacturerId: $data['manufacturerId'],
            updatedAt: Carbon::parse($data['updatedAt']),
            createdAt: Carbon::parse($data['createdAt']),
        );
    }
}