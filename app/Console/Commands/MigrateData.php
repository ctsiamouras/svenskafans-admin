<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MigrateData extends Command
{
    public const LOCAL_TABLE_NAME = 'local_table_name';
    public const COLUMNS = 'columns';

    public const DATABASE_AD_MANAGEMENT = 'CY_AdManagement';
    public const DATABASE_BIG_FORUM = 'CY_BigForum';
    public const DATABASE_CONTENT = 'CY_Content';
    public const DATABASE_ERROR = 'CY_Error';
    public const DATABASE_FORUM = 'CY_Forum';
    public const DATABASE_MEMBER = 'CY_Member';
    public const DATABASE_SURVEY = 'CY_Survey';

    public const TABLE_ADMIN_USER = 'AdminUser';
    public const TABLE_SPORT = 'Sport';
    public const TABLE_COUNTRY = 'Country';
    public const TABLE_SITE = 'Site';
    public const TABLE_LEAGUE = 'League';
    public const TABLE_TEAM = 'Team';
    public const TABLE_ADMIN_ACCESS = 'AdminAccess';

    public const DATATABLES_PER_DATABASE = [
        self::DATABASE_CONTENT => [
            self::TABLE_ADMIN_USER,
            self::TABLE_SPORT,
            self::TABLE_COUNTRY,
            self::TABLE_SITE,
            self::TABLE_LEAGUE,
            self::TABLE_TEAM,
            self::TABLE_ADMIN_ACCESS,
        ]
    ];

    public const BOOLEAN_COLUMNS = [
        self::TABLE_ADMIN_USER => [
            'Locked',
            'HasPhoto',
            'ShowEmail',
        ],
        self::TABLE_SITE => [
            'IsVisible',
            'UseInMember',
            'ShowInMobile',
            'ShowInLeftMenu',
            'LeagueLeapsOverTwoYears',
            'HasTournament',
        ],
        self::TABLE_LEAGUE => [
            'ShowInMobile',
        ],
        self::TABLE_TEAM => [
            'HasTeamPage',
            'MapPlayers',
        ],
    ];

    public const NULL_COLUMNS_TO_IGNORE_RECORD = [
        self::TABLE_ADMIN_USER => ['Password'],
    ];

    public const DEFAULT_VALUES_ON_NULL_PER_COLUMN = [
        self::TABLE_LEAGUE => [
            'LivescoreSortOrder' => 9999,
        ],
    ];

    public const KEEP_RECORDS_WITH_FOREIGN_KEYS_THAT_DO_NOT_EXIST = [
        self::TABLE_ADMIN_USER => true,
        self::TABLE_SITE => true,
        self::TABLE_LEAGUE => true,
        self::TABLE_TEAM => true,
        self::TABLE_ADMIN_ACCESS => false,
    ];

    public const PRIMARY_KEY_PER_TABLE = [
        self::TABLE_ADMIN_USER => 'AdminUserID',
        self::TABLE_SPORT => 'SportID',
        self::TABLE_COUNTRY => 'CountryID',
        self::TABLE_SITE => 'SiteID',
        self::TABLE_LEAGUE => 'LeagueID',
        self::TABLE_TEAM => 'TeamID',
        self::TABLE_ADMIN_ACCESS => 'AdminAccessID',
    ];

    public const UNIQUE_COLUMNS_PER_TABLE = [
        self::TABLE_ADMIN_USER => ['UserName'],
        self::TABLE_SPORT => ['SportID'],
        self::TABLE_COUNTRY => ['CountryName'],
        self::TABLE_SITE => ['SiteURL'],
        self::TABLE_LEAGUE => ['LeagueUrl'],
        self::TABLE_TEAM => ['TeamName'],
        self::TABLE_ADMIN_ACCESS => ['AdminAccessID'],
    ];

    public const MAPPING_PER_TABLE = [
        self::TABLE_ADMIN_USER => [
            self::LOCAL_TABLE_NAME => 'users',
            self::COLUMNS => [
                'AdminUserID' => 'id',
                'FirstName' => 'first_name',
                'LastName' => 'last_name',
                'Email' => 'email',
                'NicName' => 'nickname',
                'UserName' => 'username',
                'Password' => 'password',
                'Phone' => 'phone',
                'LastLoggin' => 'last_login',
                'LastPWDChange' => 'last_password_change',
                'FailedLoggin' => 'failed_login',
                'Locked' => 'locked',
                'FK_AdminUserTypeID' => 'user_role_id',
                'HasPhoto' => 'has_photo',
                'ShowEmail' => 'show_email',
                'TwitterName' => 'twitter_name',
                'ResourceVersion' => 'resource_version',
            ],
        ],
        self::TABLE_SPORT => [
            self::LOCAL_TABLE_NAME => 'sports',
            self::COLUMNS => [
                'SportID' => 'id',
                'SportName' => 'name',
            ],
        ],
        self::TABLE_COUNTRY => [
            self::LOCAL_TABLE_NAME => 'countries',
            self::COLUMNS => [
                'CountryID' => 'id',
                'CountryName' => 'name',
                'FlagURL' => 'flag_url',
            ],
        ],
        self::TABLE_SITE => [
            self::LOCAL_TABLE_NAME => 'sites',
            self::COLUMNS => [
                'SiteID' => 'id',
                'SiteName' => 'name',
                'SiteURL' => 'url',
                'IsVisible' => 'show_in_lists',
                'MenuColor' => 'menu_color',
                'HeaderColor' => 'header_color',
                'META_Keywords' => 'meta_keywords',
                'META_Description' => 'meta_description',
                'UseInMember' => 'use_in_member',
                'TextColor' => 'text_color',
                'FirstGameDate' => 'first_game_date',
                'ShowInMobile' => 'show_in_mobile',
                'ShowInLeftMenu' => 'show_in_left_menu',
                'Title' => 'title',
                'LeagueLeapsOverTwoYears' => 'league_leaps_over_two_years',
                'SortOrder' => 'sort_order',
                'FK_SportID' => 'sport_id',
                'FK_CountryID' => 'country_id',
                'HasTournament' => 'has_tournament',
                'ResourceVersion' => 'resource_version',
            ],
        ],
        self::TABLE_LEAGUE => [
            self::LOCAL_TABLE_NAME => 'leagues',
            self::COLUMNS => [
                'LeagueID' => 'id',
                'LeagueName' => 'name',
                'FK_SiteID' => 'site_id',
                'ShowInMobile' => 'show_in_mobile',
                'LeagueTableDividers' => 'table_dividers',
                'LeagueUrl' => 'url',
                'LivescoreSortOrder' => 'live_score_sort_order',
                'CollectionPageIntroText' => 'collection_page_intro_text',
                'FK_TournamentID' => 'tournament_id',
                'ResourceVersion' => 'resource_version',
            ],
        ],
        self::TABLE_TEAM => [
            self::LOCAL_TABLE_NAME => 'teams',
            self::COLUMNS => [
                'TeamID' => 'id',
                'TeamName' => 'name',
                'TeamNameLong' => 'long_name',
                'TeamNameShort' => 'short_name',
                'FK_SiteID' => 'site_id',
                'FK_LeagueID' => 'league_id',
                'HasTeamPage' => 'has_team_page',
                'Created' => 'created_at',
                'BrandName' => 'brand_name',
                'MsMessage' => 'ms_message',
                'PlayersTeamImageId' => 'players_team_image_id',
                'MapPlayers' => 'map_players',
            ],
        ],
        self::TABLE_ADMIN_ACCESS => [
            self::LOCAL_TABLE_NAME => 'user_team',
            self::COLUMNS => [
                'AdminAccessID' => 'id',
                'FK_AdminUserID' => 'user_id',
                'FK_TeamID' => 'team_id',
            ],
        ],
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bar = $this->output->createProgressBar(count(self::MAPPING_PER_TABLE));
        $bar->start();

        $success = 0;
        $errors = 0;
        $limit = 1000;
        $connectionName = env('DB_CONNECTION2');

        foreach (self::DATATABLES_PER_DATABASE as $database => $datatables) {
            // set database name in the DB connection
            Config::set('database.connections.sqlsrv_production.database', $database);
            DB::purge('sqlsrv_production');
            $envDatabase = Config::get('database.connections.sqlsrv_production.database');

            $this->info("\n\nDatabase: {$envDatabase}");

            // get data for each datatable in the DB
            foreach ($datatables as $productionTable) {
                try {
                    // Get production table data
                    $localTable = self::MAPPING_PER_TABLE[$productionTable][self::LOCAL_TABLE_NAME];
                    $productionPrimaryKey = self::PRIMARY_KEY_PER_TABLE[$productionTable];
                    $productionColumns = implode(',', array_keys(self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS]));

                    // Get foreign key constraints for the specified table
                    $foreignKeys = DB::select("
                        SELECT column_name, referenced_table_name
                        FROM information_schema.key_column_usage
                        WHERE referenced_table_name IS NOT NULL
                        AND table_name = ?
                    ", [$localTable]);

                    // set related tables per foreign key
                    $relatedTables = [];
                    foreach ($foreignKeys as $foreignKey) {
                        $relatedTables[$foreignKey->COLUMN_NAME] = $foreignKey->REFERENCED_TABLE_NAME;
                    }

                    // get data from production DB
                    $offset = 0;
                    $sqlQuery = "SELECT {$productionColumns} FROM {$productionTable} ORDER BY {$productionPrimaryKey} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";
                    $this->info("\n\n{$sqlQuery}");

                    // while we get records from production, insert data to local
                    while ($results = DB::connection($connectionName)->select($sqlQuery)) {
                        foreach ($results as $result) {
                            // initiate data to insert
                            $data = [
                                'created_at' => Carbon::today(),
                                'updated_at' => Carbon::today(),
                            ];
                            $uniqueData = [];

                            foreach ($result as $productionColumn => $value) {
                                // set the local column name based on the production column name
                                $localColumn = self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS][$productionColumn];

                                // ignore record if its foreign keys does not exist in the related table
                                if (in_array($localColumn, array_keys($relatedTables))) {
                                    $foreignKeyExists = false;

                                    // if value is not null, then check foreign key id exist in the related table
                                    // if values is null then assert that foreign key does not exist
                                    if ($value !== null) {
                                        $relatedLocalTable = $relatedTables[$localColumn];
                                        $sqlQueryRelatedTable = "SELECT id FROM {$relatedLocalTable} WHERE id = {$value}";
                                        $foreignKeyExists = DB::select($sqlQueryRelatedTable) ? true : false;
                                    }

                                    // if foreign key does not exist then
                                    if (!$foreignKeyExists) {
                                        // if foreign key does not exist, but we want to keep the record, then set to NULL the foreign key column
                                        if (self::KEEP_RECORDS_WITH_FOREIGN_KEYS_THAT_DO_NOT_EXIST[$productionTable] === true) {
                                            $value = null;
                                        // else we do not insert the record when foreign key does not exist
                                        } else {
                                            $data = [];

                                            break;
                                        }
                                    }
                                }

                                // ignore record when specific column has NULL value
                                if (isset(self::NULL_COLUMNS_TO_IGNORE_RECORD[$productionTable]) && in_array($productionColumn, self::NULL_COLUMNS_TO_IGNORE_RECORD[$productionTable]) && $value === null) {
                                    $data = [];

                                    break;
                                }

                                // set NULL value for date columns with 1900-01-01 value
                                if (str_contains($value, '1900-01-01')) {
                                    $value = null;
                                }

                                // cast values of boolean fields to boolean
                                if (isset(self::BOOLEAN_COLUMNS[$productionTable]) && in_array($productionColumn, self::BOOLEAN_COLUMNS[$productionTable])) {
                                    $value = (boolean) $value;
                                }

                                // set default value for specific column where its value is NULL
                                if (isset(self::DEFAULT_VALUES_ON_NULL_PER_COLUMN[$productionTable])
                                    && in_array($productionColumn, array_keys(self::DEFAULT_VALUES_ON_NULL_PER_COLUMN[$productionTable]))
                                    && $value === null) {
                                    $value = self::DEFAULT_VALUES_ON_NULL_PER_COLUMN[$productionTable][$productionColumn];
                                }

                                // add values per column
                                if (in_array($productionColumn, self::UNIQUE_COLUMNS_PER_TABLE[$productionTable])) {
                                    $uniqueData[$localColumn] = $value;
                                } else {
                                    $data[$localColumn] = $value;
                                }
                            }

                            // insert or update data based on the unique columns
                            if ($data) {
                                DB::table($localTable)->updateOrInsert(
                                    $uniqueData,
                                    $data
                                );
                            }
                        }

                        // increase offset to get the next batch of data
                        $offset += $limit;
                        $sqlQuery = "SELECT {$productionColumns} FROM {$productionTable} ORDER BY {$productionPrimaryKey} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";

                        $this->info("\n\n{$sqlQuery}");
                    }

                    ++$success;
                } catch (\Exception $e) {
                    $this->error("\n\nError: {$e->getMessage()}");

                    ++$errors;
                }

                $bar->advance();
            }
        }

        $bar->finish();

        $this->info("\n\nSuccessful table migrations: {$success}");
        $this->error("Unsuccessful table migrations: {$errors}");
    }
}
