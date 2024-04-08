<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\DataTransferObjects\Item;

use Illuminate\Support\Carbon;

final readonly class ImagesDTO
{
    public function __construct(
        public array $images,
    ) {
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            images: collect($data)
                ->map(function (array $imageData) {
                    return [
                        'url' => $imageData['url'],
                        'checksum' => $imageData['md5Checksum'],
                        'names' => collect($imageData['names'])
                            ->mapWithKeys(fn(array $nameData) => [$nameData['lang'] => $nameData['name']])
                            ->all(),
                        'created_at' => $imageData['createdAt'],
                        'updated_at' => $imageData['updatedAt']
                    ];
                })
                ->all(),
        );
    }
}