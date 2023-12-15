<?php

namespace App\JsonApi\V1\Sites;

use App\Models\Site;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereHas;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class SiteSchema extends Schema
{
    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Site::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('name')->sortable(),
            Str::make('url'),
            Boolean::make('showInLists'),
            Str::make('menuColor'),
            Str::make('headerColor'),
            Boolean::make('useInMember'),
            Str::make('textColor'),
            DateTime::make('firstGameDate'),
            Boolean::make('showInMobile'),
            Boolean::make('showInLeftMenu'),
            Str::make('title'),
            Boolean::make('leagueLeapsOverTwoYears'),
            Number::make('sortOrder')->sortable(),
            HasMany::make('teams'),
            HasMany::make('leagues'),
            BelongsTo::make('country'),
            BelongsTo::make('sport'),
            Boolean::make('hasTournament'),
            Number::make('resourceVersion'),
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
            Where::make('name'),
            Where::make('showInLists'),
            WhereHas::make($this, 'teams'),
            WhereHas::make($this, 'leagues'),
            WhereIn::make('country'),
            WhereIn::make('sport'),
            Where::make('title'),
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
