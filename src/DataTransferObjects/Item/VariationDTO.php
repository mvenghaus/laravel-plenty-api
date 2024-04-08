<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\DataTransferObjects\Item;

use Illuminate\Support\Carbon;

final readonly class VariationDTO
{
    public function __construct(
        public int $id,
        public int $itemId,
        public string $sku,
        public ?string $ean,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }

    public static function fromPimResponse(array $data): static
    {
        return new static(
            id: $data['id'],
            itemId: $data['base']['itemId'],
            sku: $data['base']['number'],
            ean: $data['barcodes'][0]['code'] ?? null,
            createdAt: Carbon::parse($data['timestamps']['createdAt']),
            updatedAt: Carbon::parse($data['timestamps']['base']),
        );
    }
}