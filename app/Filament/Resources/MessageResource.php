<?php

namespace App\Filament\Resources;

use App\Filament\Constants\PaginationConstants;
use App\Filament\Constants\TranslationPathConstants;
use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use App\Models\Team;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return true;
    }

    public static function getNavigationGroup(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_GROUP_TRANSLATION_PATH . 'forum');
    }

    public static function getNavigationLabel(): string
    {
        return __(TranslationPathConstants::ADMIN_PANEL_NAVIGATION_ITEM_TRANSLATION_PATH . 'messages');
    }

    private const NUMBER_OF_MONTHS = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('TextBody')
                    ->required()
                    ->rows(5)
//                    ->cols(20)
                    ->autosize(),
                DatePicker::make('Created')
                    ->label('Created')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated(PaginationConstants::MESSAGE_LIST_PAGINATION)
            ->columns([
                TextColumn::make('id')
                ->label('ID'),
                TextColumn::make('NicName')
                ->label('Nickname'),
                TextColumn::make('IP')
                ->label('IP'),
                TextColumn::make('Created')
                    ->date()
                    ->label('Created'),
            ])
            ->defaultSort('Created', 'desc')
            ->filters([
                Filter::make('Created')
                    ->form([
                        DatePicker::make('start_date')
                            ->native(false)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if (!$state) {
                                    $state = today()->subMonths(self::NUMBER_OF_MONTHS);
                                    $set('start_date', Str::slug($state->format('Y-m-d')));
                                } else {
                                    $state = Carbon::parse($state);
                                }

                                $endDate = $state->addMonths(self::NUMBER_OF_MONTHS)->format('Y-m-d');

                                $set('end_date', Str::slug($endDate));
                            })
                            ->nullable()
                            ->default(today()->subMonths(self::NUMBER_OF_MONTHS)),
                        DatePicker::make('end_date')
                            ->native(false)
//                            ->displayFormat($format = 'F j, Y')
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set, Forms\Get $get) {
                                if (!$state) {
                                    $startDate = $get('start_date');
                                    $endDate = Carbon::parse($startDate)->addMonths(self::NUMBER_OF_MONTHS)->format('Y-m-d');

                                    $set('end_date', Str::slug($endDate));
                                }
                            })
                            ->minDate(function (Forms\Get $get) {
                                return $get('start_date');
                            })
                            ->maxDate(function (Forms\Get $get) {
                                $startDate = $get('start_date');

                                return Carbon::parse($startDate)->addMonths(self::NUMBER_OF_MONTHS)->format('Y-m-d');
                            })
                            ->default(today())
                            ->nullable(),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(($data['start_date'] && $data['end_date']), function (Builder $q) use ($data) {
                            $startDate = Carbon::parse($data['start_date'])->startOfDay();
                            $endDate = Carbon::parse($data['end_date'])->endOfDay();

                            return $q->whereBetween('Created', [$startDate, $endDate]);
                        })
                        ->when((!$data['start_date'] || !$data['end_date']), function (Builder $q) use ($data) {
                            $startDate = today()->subMonths(self::NUMBER_OF_MONTHS)->startOfDay();
                            $endDate = today()->endOfDay();

                            return $q->whereBetween('Created', [$startDate, $endDate]);
                        })
                    ),
                SelectFilter::make('FK_TeamID')
                    ->label('Team')
                    ->searchable()
                    ->placeholder('')
                    ->options(function () {
                        return Team::orderBy('TeamName')->get()->pluck('TeamName', 'id');
                    })
                    ->default(Team::orderBy('TeamName', 'ASC')->first()->id)
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['value'] !== null, function (Builder $q) use ($data) {
                            return $q->where('FK_TeamID', $data['value']);
                        })
                        ->when($data['value'] === null, function (Builder $q) use ($data) {
                            $teamId = Team::first()->id;

                            return $q->where('FK_TeamID', $teamId);
                        })
                    ),
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
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
