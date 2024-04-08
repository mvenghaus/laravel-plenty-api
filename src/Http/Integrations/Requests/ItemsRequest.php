<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\Http\Integrations\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class ItemsRequest extends Request
{
    use AcceptsJson;

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/items';
    }

    protected function defaultQuery(): array
    {
        return [
            'with' => 'itemCrossSelling'
        ];
    }
}
