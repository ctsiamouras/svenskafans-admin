<?php

namespace App\Filament\Resources;

use App\Filament\Constants\PaginationConstants;
use App\Filament\Constants\TranslationPathConstants;
use App\Filament\Resources\SiteResource\Pages;
use App\Models\Country;
use App\Models\Site;
use App\Models\Sport;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    public static function getNavigationGroup(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_GROUP_TRANSLATION_PATH . 'administration');
    }

    public static function getNavigationLabel(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_ITEM_TRANSLATION_PATH . 'sites');
    }

    public static function getModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.name'))
                    ->required(),
                TextInput::make('title')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.title'))
                    ->required(),
                Textarea::make('meta_description')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.meta_description'))
                    ->rows(4)
                    ->required(),
                TextInput::make('url')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.url'))
                    ->required(),
                Select::make('country_id')
                    ->options(self::countryOptions())
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.country'))
                    ->required(),
                Select::make('sport_id')
                    ->options(self::sportOptions())
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.sport'))
                    ->required(),
                ColorPicker::make('text_color')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.text_color'))
                    ->required(),
                ColorPicker::make('header_color')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.header_color'))
                    ->required(),
                ColorPicker::make('menu_color')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.menu_color'))
                    ->required(),
                Checkbox::make('show_in_lists')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.show_in_lists'))
                    ->columnStart(1),
                Checkbox::make('use_in_member')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.use_in_member')),
                Checkbox::make('show_in_mobile')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.show_in_mobile')),
                Checkbox::make('show_in_left_menu')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.show_in_left_menu')),
                Checkbox::make('league_leaps_over_two_years')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.form.league_leaps_over_two_years')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated(PaginationConstants::DEFAULT_LIST_PAGINATION)
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('id')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.id'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.url'))
                    ->sortable(),
                CheckboxColumn::make('show_in_lists')
                    ->disabled()
                    ->alignCenter()
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.show_in_lists')),
                CheckboxColumn::make('use_in_member')
                    ->disabled()
                    ->alignCenter()
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.use_in_member')),
                CheckboxColumn::make('show_in_mobile')
                    ->disabled()
                    ->alignCenter()
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.show_in_mobile')),
                CheckboxColumn::make('show_in_left_menu')
                    ->disabled()
                    ->alignCenter()
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.show_in_left_menu')),
                TextColumn::make('country.name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.country'))
                    ->sortable(),
                TextColumn::make('sport.name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.sport'))
                    ->sortable(),
                CheckboxColumn::make('has_tournament')
                    ->disabled()
                    ->alignCenter()
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'sites.table.has_tournament')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn ($record) => $record->show_in_lists),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
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
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }

    private static function countryOptions(): array {
        return Country::all()->pluck('name', 'id')->toArray();
    }

    private static function sportOptions(): array {
        return Sport::all()->pluck('name', 'id')->toArray();
    }
}
