<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\Http\Integrations\Requests\V2;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class PropertiesRequest extends Request
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
        return '/v2/properties';
    }

    protected function defaultQuery(): array
    {
        return [
            'with' => 'names,selections,selections.names'
        ];
    }
}
