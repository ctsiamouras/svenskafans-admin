<?php

namespace App\Filament\Resources;

use App\Constants\PaginationConstants;
use App\Constants\TranslationPathConstants;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
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
                TextInput::make('first_name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.first_name'))
                    ->required(),
                TextInput::make('last_name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.last_name'))
                    ->required(),
                TextInput::make('nickname')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.nickname')),
                TextInput::make('username')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.username'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('password')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.password'))
                    ->required(function (string $operation) {
                        return $operation === 'create';
                    })
                    ->password(),
                TextInput::make('phone')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.phone')),
                TextInput::make('email')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.email'))
                    ->email()
//                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('twitter_name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.twitter_name')),
                Select::make('user_role_id')
                    ->options(self::userRoleOptions())
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.user_role'))
                    ->required(),
                Select::make('teams')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.teams'))
                    ->multiple()
                    ->relationship('teams', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated(PaginationConstants::DEFAULT_LIST_PAGINATION)
            ->columns([
                TextColumn::make('first_name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.first_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.last_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label(__(TranslationPathConstants::ADMINISTRATION_TRANSLATION_PATH . 'users.username'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
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
                            ->options(Site::orderBy('name')->get()->pluck('name', 'id'))
                            ->afterStateUpdated(function (callable $set) {
                                $set('team_select', null);
                            }),
                        Select::make('team_select')
                            ->label('Team')
                            ->searchable()
                            ->placeholder('')
                            ->options(function (callable $get) {
                                $site = Site::find($get('site_select'));

                                return $site ? $site->teams->pluck('name', 'id') : null;
                            }),
                    ])
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['team_select']) {
                            return 'Team: ' . Team::findOrFail($data['team_select'])->name;
                        }

                        return null;
                    })
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['team_select'], function (Builder $q) use ($data) {
                            return $q->whereHas('teams', function ($q) use ($data) {
                                $q->where('teams.id', $data['team_select']);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
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
