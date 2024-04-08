<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\Http\Integrations;

use Closure;

class Configuration
{
    public function __construct(
        public string $endpoint,
        public string $username,
        public string $password,
        public ?string $authenticator,
        public Closure $onAuthenticatorUpdate,
        public bool $debug = false
    ) {
    }
}