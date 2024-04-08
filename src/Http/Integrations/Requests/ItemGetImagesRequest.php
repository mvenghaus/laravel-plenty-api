<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\Http\Integrations\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ItemGetImagesRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        public int $itemId
    ) {
    }


    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/items/' . $this->itemId . '/images';
    }
}
