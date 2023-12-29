<?php

namespace App\Filament\Resources;

use App\Constants\PaginationConstants;
use App\Constants\TranslationPathConstants;
use App\Filament\Resources\LeagueResource\Pages;
use App\Filament\Resources\LeagueResource\RelationManagers;
use App\Models\League;
use App\Models\Site;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeagueResource extends Resource
{
    protected static ?string $model = League::class;

    public static function getNavigationGroup(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_GROUP_TRANSLATION_PATH . 'administration');
    }

    public static function getNavigationLabel(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_ITEM_TRANSLATION_PATH . 'leagues');
    }

    public static function getModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.form.name'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('url')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.form.url'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                Select::make('site_id')
                    ->options(self::siteOptions())
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.form.site'))
                    ->required(),
                TextInput::make('table_dividers')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.form.table_dividers')),
                Checkbox::make('show_in_mobile')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.form.show_in_mobile')),
//                Select::make('tournament_id')
//                    ->options(self::tournamentOptions())
//                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.country'))
//                    ->required(),
                Textarea::make('collection_page_intro_text')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.form.collection_page_intro_text'))
                    ->columnStart(1)
//                    ->columnSpanFull()
                    ->rows(4),
                Hidden::make('live_score_sort_order')
                    ->default(function () {
                        $maxOrderValue = League::max('live_score_sort_order');
                        return $maxOrderValue + 1;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated(PaginationConstants::DEFAULT_LIST_PAGINATION)
            ->reorderable('live_score_sort_order')
            ->defaultSort('name')
            ->columns([
                TextColumn::make('id')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.table.id'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.table.url')),
                TextColumn::make('site.name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.table.site')),
                TextColumn::make('table_dividers')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.table.table_dividers')),
                TextColumn::make('live_score_sort_order')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.table.live_score_sort_order'))
                    ->alignCenter()
                    ->sortable(),
                CheckboxColumn::make('show_in_mobile')
                    ->disabled()
                    ->alignCenter()
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'leagues.table.show_in_mobile')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLeagues::route('/'),
            'create' => Pages\CreateLeague::route('/create'),
            'edit' => Pages\EditLeague::route('/{record}/edit'),
        ];
    }

    private static function siteOptions(): array {
        return Site::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

//    private static function tournamentOptions(): array {
//        return Tournament::all()->pluck('name', 'id')->toArray();
//    }
}
