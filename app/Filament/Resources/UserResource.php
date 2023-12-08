<?php

namespace App\Filament\Resources;

use App\Filament\Constants\PaginationConstants;
use App\Filament\Constants\TranslationPathConstants;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\Site;
use App\Models\Team;
use App\Models\User;
use App\Models\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Unique;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationGroup(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_GROUP_TRANSLATION_PATH . 'administration');
    }

    public static function getNavigationLabel(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_ITEM_TRANSLATION_PATH . 'users');
    }

    public static function getModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('FirstName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.first_name'))
                    ->required(),
                TextInput::make('LastName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.last_name'))
                    ->required(),
                TextInput::make('NicName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.nickname')),
                TextInput::make('UserName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.username'))
//                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('password')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.password'))
                    ->hiddenOn(EditUser::class)
                    ->password()
                    ->required(),
                TextInput::make('Phone')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.phone')),
                TextInput::make('Email')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.email'))
                    ->email()
//                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('TwitterName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.twitter_name')),
                Select::make('FK_AdminUserTypeID')
                    ->options(self::userRoleOptions())
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.user_role'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated(PaginationConstants::DEFAULT_LIST_PAGINATION)
            ->columns([
                TextColumn::make('FirstName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.first_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('LastName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.last_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('UserName')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.username'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('Email')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.email'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('Team')
                    ->form([
                        Select::make('site_select')
                            ->label('Site')
                            ->searchable()
                            ->placeholder('')
                            ->options(Site::orderBy('SiteName')->get()->pluck('SiteName', 'id'))
                            ->afterStateUpdated(function (callable $set) {
                                $set('team_select', null);
                            }),
                        Select::make('team_select')
                            ->label('Team')
                            ->searchable()
                            ->placeholder('')
                            ->options(function (callable $get) {
                                $site = Site::find($get('site_select'));

                                return $site ? $site->teams->pluck('TeamName', 'id') : null;
                            }),
                    ])
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['team_select']) {
                            return 'Team: ' . Team::findOrFail($data['team_select'])->TeamName;
                        }

                        return null;
                    })
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['team_select'], function (Builder $q) use ($data) {
                            return $q->whereHas('teams', function ($q) use ($data) {
                                $q->where('team.id', $data['team_select']);
                            });
                        })
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    private static function userRoleOptions(): array {
        $userRoles = UserRole::all();
        $options = [];

        foreach ($userRoles as $userRole) {
            $options[$userRole->id] = __(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . "users.user_roles.{$userRole->role}");
        }

        return $options;
    }
}
