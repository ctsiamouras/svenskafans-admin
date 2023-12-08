<?php

namespace App\Filament\Resources;

use App\Filament\Constants\PaginationConstants;
use App\Filament\Constants\TranslationPathConstants;
use App\Filament\Resources\TeamResource\Pages;
use App\Models\League;
use App\Models\Site;
use App\Models\Team;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    public static function getNavigationGroup(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_GROUP_TRANSLATION_PATH . 'administration');
    }

    public static function getNavigationLabel(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_ITEM_TRANSLATION_PATH . 'teams');
    }

    public static function getModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('FK_SiteID')
                    ->options(self::siteOptions())
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.form.site'))
                    ->required(),
                Select::make('FK_LeagueID')
                    ->options(self::leagueOptions())
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.form.league'))
                    ->required(),
                TextInput::make('TeamName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.form.name'))
                    ->required(),
                TextInput::make('TeamNameLong')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.form.long_name')),
                TextInput::make('TeamNameShort')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.form.short_name')),
                TextInput::make('BrandName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.form.brand_name')),
                Checkbox::make('HasTeamPage')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.form.has_team_page')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated(PaginationConstants::DEFAULT_LIST_PAGINATION)
            ->defaultSort('TeamName')
            ->columns([
                TextColumn::make('id')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.table.id')),
                TextColumn::make('TeamName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.table.name'))
                    ->searchable(),
                TextColumn::make('site.SiteName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.table.site')),
                TextColumn::make('league.name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'teams.table.league')),
            ])
            ->filters([
                SelectFilter::make('FK_SiteID')
                    ->label('Site')
                    ->searchable()
                    ->preload()
                    ->options(function () {
                        return Site::orderBy('SiteName')->get()->pluck('SiteName', 'id');
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }

    private static function siteOptions(): array {
        return Site::all()->pluck('SiteName', 'id')->toArray();
    }

    private static function leagueOptions(): array {
        return League::all()->pluck('name', 'id')->toArray();
    }
}
