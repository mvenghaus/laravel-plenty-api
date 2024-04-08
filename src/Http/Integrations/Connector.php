<?php

declare(strict_types=1);

namespace Mvenghaus\PlentyApi\Http\Integrations;

use Mvenghaus\PlentyApi\Http\Integrations\Requests\GetAccessTokenRequest;
use Psr\Http\Message\RequestInterface;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Auth\AccessTokenAuthenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\PendingRequest;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class Connector extends \Saloon\Http\Connector
{
    use AlwaysThrowOnErrors;
    use AcceptsJson;
    use ClientCredentialsGrant;

    public function __construct(
        public Configuration $configuration,
    ) {
        if ($this->configuration->debug) {
            $this->debugRequest(
                function (PendingRequest $pendingRequest, RequestInterface $psrRequest) {
                    echo $pendingRequest->getUrl().PHP_EOL;
                }
            );
        }

        if (empty($this->configuration->authenticator)) {
            $this->updateAccessToken();
            return;
        }

        $authenticator = AccessTokenAuthenticator::unserialize($this->configuration->authenticator);

        $this->authenticate(new TokenAuthenticator($authenticator->getAccessToken()));

        if ($authenticator->hasExpired()) {
            $this->updateAccessToken();
        }
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return $response->status() !== 200;
    }

    public function updateAccessToken(): void
    {
        $authenticator = $this->getAccessToken();

        $this->authenticate(new TokenAuthenticator($authenticator->getAccessToken()));

        ($this->configuration->onAuthenticatorUpdate)($authenticator->serialize());
    }

    public function resolveBaseUrl(): string
    {
        return $this->configuration->endpoint;
    }

    protected function defaultHeaders(): array
    {
        return [];
    }

    protected function defaultConfig(): array
    {
        return [];
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId($this->configuration->username)
            ->setClientSecret($this->configuration->password)
            ->setTokenEndpoint('login');
    }

    protected function resolveAccessTokenRequest(
        OAuthConfig $oauthConfig,
        array $scopes = [],
        string $scopeSeparator = ' '
    ): Request {
        return new GetAccessTokenRequest($oauthConfig);
    }


}
