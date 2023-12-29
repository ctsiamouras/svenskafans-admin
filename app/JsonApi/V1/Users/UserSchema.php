<?php

namespace App\JsonApi\V1\Users;

use App\Models\User;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class UserSchema extends Schema
{
    /**
    * The maximum include path depth.
    *
    * @var int
    */
    protected int $maxDepth = 3;

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = User::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('first_name')->sortable(),
            Str::make('lastName')->sortable(),
            Str::make('email')->readOnly(),
            Str::make('username')->sortable()->readOnly(),
            Str::make('nickname'),
            Str::make('phone'),
            DateTime::make('lastLogin'),
            DateTime::make('lastPasswordChange'),
            Number::make('failedLogin'),
            Boolean::make('locked'),
            BelongsTo::make('userRole', 'role')->type('user-roles')->readOnly(),
            Boolean::make('hasPhoto'),
            Boolean::make('showEmail')->readOnly(),
            Str::make('twitterName'),
            Number::make('resourceVersion'),
            Str::make('name')->sortable(),
            BelongsToMany::make('teams')->readOnly(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
        ];
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            Where::make('username'), // Allow filtering the User resource by username
            Where::make('lastName'),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }
}
