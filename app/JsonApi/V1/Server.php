<?php

namespace App\JsonApi\V1;

use App\JsonApi\V1\Countries\CountrySchema;
use App\JsonApi\V1\Leagues\LeagueSchema;
use App\JsonApi\V1\Sites\SiteSchema;
use App\JsonApi\V1\Sports\SportSchema;
use App\JsonApi\V1\Teams\TeamSchema;
use App\JsonApi\V1\UserRoles\UserRoleSchema;
use App\JsonApi\V1\Users\UserSchema;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{
    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        // no-op
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            CountrySchema::class,
            LeagueSchema::class,
            SiteSchema::class,
            SportSchema::class,
            TeamSchema::class,
            UserRoleSchema::class,
            UserSchema::class,
        ];
    }

    /**
     * Determine if the server is authorizable.
     *
     * @return bool
     */
    public function authorizable(): bool
    {
        return false;
    }
}
