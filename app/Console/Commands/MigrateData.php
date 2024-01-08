<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

ini_set('memory_limit', '4096M');

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
    public const TABLE_GAME = 'Game';
    public const TABLE_COLLECTION_PAGE = 'CollectionPage';
    public const TABLE_IMAGE = 'Image';
    public const TABLE_SURVEY = 'Survey';
    public const TABLE_ANSWER = 'Answer';
    public const TABLE_ARTICLE = 'Article';
    public const TABLE_COLLECTION_PAGE_LINKS = 'CollectionPageLinks';
    public const TABLE_MEDIA_ITEM = 'MediaItem';

    public const DATATABLES_PER_DATABASE = [
        self::DATABASE_CONTENT => [
            self::TABLE_ADMIN_USER,
            self::TABLE_SPORT,
            self::TABLE_COUNTRY,
            self::TABLE_SITE,
            self::TABLE_LEAGUE,
            self::TABLE_TEAM,
            self::TABLE_ADMIN_ACCESS,
            self::TABLE_GAME,
            self::TABLE_COLLECTION_PAGE,
            self::TABLE_IMAGE,
            self::TABLE_SURVEY,
            self::TABLE_ANSWER,
            self::TABLE_ARTICLE,
            self::TABLE_COLLECTION_PAGE_LINKS,
            self::TABLE_MEDIA_ITEM,
            self::TABLE_ARTICLE,
        ],
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
        self::TABLE_GAME => [
            'DisplayInLivescore',
        ],
        self::TABLE_COLLECTION_PAGE => [
            'IsActive',
        ],
        self::TABLE_ARTICLE => [
            'team_show_only',
            'hide_header',
            'hide_author_info',
            'links_in_text',
            'hide_read_more_box',
            'hide_share_box',
            'update_linked_text',
        ],
    ];

    public const NULL_COLUMNS_TO_IGNORE_RECORD = [
        self::TABLE_ADMIN_USER => ['Password'],
        self::TABLE_SPORT => ['SportName'],
        self::TABLE_COUNTRY => ['CountryName'],
        self::TABLE_LEAGUE => ['LeagueName'],
        self::TABLE_TEAM => ['TeamName'],
        self::TABLE_COLLECTION_PAGE => ['Name'],
        self::TABLE_ANSWER => ['AnswerText'],
        self::TABLE_COLLECTION_PAGE_LINKS => ['ArticleId'],
    ];

    public const DEFAULT_VALUES_ON_NULL_PER_COLUMN = [
        self::TABLE_LEAGUE => [
            'LivescoreSortOrder' => 9999,
        ],
        self::TABLE_GAME => [
            'FK_GameStatusID' => 1,
        ],
        self::TABLE_IMAGE => [
            'Deleted' => null,
        ],
        self::TABLE_ARTICLE => [
            'ViewAmount' => 0,
            'CommentAmount' => 0,
            'ViewMobile' => 0,
            'ViewApp' => 0,
            'ViewWeb' => 0,
        ],
        self::TABLE_MEDIA_ITEM => [
            'SortOrder' => 9999,
        ],
    ];

    public const IGNORE_RECORDS_FOR_SPECIFIC_FOREIGN_KEYS_WHERE_ID_DOES_NOT_EXIST = [
        self::TABLE_ADMIN_ACCESS => [
            'FK_AdminUserID',
            'FK_TeamID',
        ],
        self::TABLE_GAME => [
            'TeamHomeID',
            'TeamAwayID',
        ],
        self::TABLE_SURVEY => [
            'FK_SurveyTypeID',
            'FK_TeamID',
        ],
        self::TABLE_ANSWER => [
            'FK_SurveyID',
        ],
        self::TABLE_MEDIA_ITEM => [
            'FK_MediaCollectionId'
        ],
    ];

    public const PRIMARY_KEY_PER_TABLE = [
        self::TABLE_ADMIN_USER => 'AdminUserID',
        self::TABLE_SPORT => 'SportID',
        self::TABLE_COUNTRY => 'CountryID',
        self::TABLE_SITE => 'SiteID',
        self::TABLE_LEAGUE => 'LeagueID',
        self::TABLE_TEAM => 'TeamID',
        self::TABLE_ADMIN_ACCESS => 'AdminAccessID',
        self::TABLE_GAME => 'GameID',
        self::TABLE_COLLECTION_PAGE => 'Id',
        self::TABLE_IMAGE => 'ImageID',
        self::TABLE_SURVEY => 'SurveyID',
        self::TABLE_ANSWER => 'AnswerID',
        self::TABLE_ARTICLE => 'ArticleID',
        self::TABLE_COLLECTION_PAGE_LINKS => 'ArticleID',
        self::TABLE_MEDIA_ITEM => 'MediaItemId',
    ];

//    public const UNIQUE_COLUMNS_PER_TABLE = [
//        self::TABLE_ADMIN_USER => ['UserName'],
//        self::TABLE_SPORT => ['SportID'],
//        self::TABLE_COUNTRY => ['CountryName'],
//        self::TABLE_SITE => ['SiteURL'],
//        self::TABLE_LEAGUE => ['LeagueName'],
//        self::TABLE_TEAM => ['TeamName'],
//        self::TABLE_ADMIN_ACCESS => ['AdminAccessID'],
//        self::TABLE_GAME => ['GameID'],
//        self::TABLE_COLLECTION_PAGE => ['Name'],
//        self::TABLE_IMAGE => ['ImageID'],
//    ];

    public const UNIQUE_LOCAL_COLUMNS_PER_TABLE = [
        self::TABLE_ADMIN_USER => ['username'],
        self::TABLE_SPORT => ['id'],
        self::TABLE_COUNTRY => ['name'],
        self::TABLE_SITE => ['url'],
        self::TABLE_LEAGUE => ['name'],
        self::TABLE_TEAM => ['name'],
        self::TABLE_ADMIN_ACCESS => ['id'],
        self::TABLE_GAME => ['id'],
        self::TABLE_COLLECTION_PAGE => ['name'],
        self::TABLE_IMAGE => ['id'],
        self::TABLE_SURVEY => ['id'],
        self::TABLE_ANSWER => ['poll_id', 'answer'],
        self::TABLE_ARTICLE => ['id'],
        self::TABLE_COLLECTION_PAGE_LINKS => ['id'], // article table
        self::TABLE_MEDIA_ITEM => ['id'],
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
                'META_Description' => 'meta_description',
                'UseInMember' => 'use_in_member',
                'TextColor' => 'text_color',
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
        self::TABLE_GAME => [
            self::LOCAL_TABLE_NAME => 'games',
            self::COLUMNS => [
                'GameID' => 'id',
                'ExternalGameID' => 'external_game_id',
                'TeamHomeID' => 'team_home_id',
                'TeamAwayID' => 'team_away_id',
                'EventDateTime' => 'start_date',
                'FK_GameTypeID' => 'game_type_id',
                'Referee' => 'referee',
                'Arena' => 'arena',
                'Spectators' => 'spectators',
                'GoalHome' => 'goal_home',
                'GoalAway' => 'goal_away',
                'FK_GameStatusID' => 'game_status_id',
                'Created' => 'created_at',
                'Modified' => 'updated_at',
                'DisplayInLivescore' => 'show_in_live_score',
            ],
        ],
        self::TABLE_COLLECTION_PAGE => [
            self::LOCAL_TABLE_NAME => 'collection_pages',
            self::COLUMNS => [
                'Id' => 'id',
                'SiteId' => 'site_id',
                'Name' => 'name',
                'Url' => 'url',
                'DateCreated' => 'created_at',
                'DateUpdated' => 'updated_at',
                'IsActive' => 'is_active',
                'PageIntroText' => 'page_intro_text',
            ],
        ],
        self::TABLE_IMAGE => [
            self::LOCAL_TABLE_NAME => 'images',
            self::COLUMNS => [
                'ImageID' => 'id',
                'Filesize' => 'file_size',
                'Width' => 'width',
                'Height' => 'height',
                'Header' => 'header',
                'Description' => 'description',
                'FK_SiteID' => 'site_id',
                'FK_TeamID' => 'team_id',
                'RightsText' => 'rights_text',
                'Created' => 'created_at',
                'Deleted' => 'deleted_at',
                'FK_AdminUserID' => 'user_id',
            ],
        ],
        self::TABLE_SURVEY => [
            self::LOCAL_TABLE_NAME => 'polls',
            self::COLUMNS => [
                'SurveyID' => 'id',
                'Question' => 'question',
                'FK_SurveyTypeID' => 'poll_type_id',
                'NoVotes' => 'number_of_votes',
                'FK_TeamID' => 'team_id',
            ],
        ],
        self::TABLE_ANSWER => [
            self::LOCAL_TABLE_NAME => 'poll_answers',
            self::COLUMNS => [
                'AnswerID' => 'id',
                'FK_SurveyID' => 'poll_id',
                'AnswerText' => 'answer',
                'NoAnswers' => 'number_of_answers',
            ],
        ],
        self::TABLE_ARTICLE => [
            self::LOCAL_TABLE_NAME => 'articles',
            self::COLUMNS => [
                'ArticleID' => 'id',
                'FK_TeamID' => 'team_id',
                'FK_SiteID' => 'site_id',
                'Header' => 'header',
                'Intro' => 'intro',
                'Textbody' => 'text_body',
                'UniqueURI' => 'url',
                'FK_AdminUserID' => 'user_id',
                'FK_GameID' => 'game_id',
                'FK_ArticleCategoryID' => 'article_type_id',
                'NicName' => 'nickname',
                'IsDeleted' => 'deleted_at',
                'Created' => 'created_at',
                'Published' => 'published',
                'Modified' => 'updated_at',
                'OldArticleID' => 'old_article_id',
                'ViewAmount' => 'number_of_views',
                'CommentAmount' => 'number_of_comments',
                'ShowComments' => 'comment_access_right_id',
                'FK_ImageID' => 'image_id',
                'ImageCaption' => 'image_caption',
                'TeamShowOnly' => 'team_show_only',
                'HideHeader' => 'hide_header',
                'HideAuthorInfo' => 'hide_author_info',
                'LinksInText' => 'links_in_text',
                'TextbodyLinked' => 'body_text_linked',
//                'FK_MediaCollectionId' => '',
                'ReadMoreLinks' => 'read_more_links',
                'ViewMobile' => 'mobile_views',
                'ViewApp' => 'app_views',
                'ViewWeb' => 'web_views',
                'HideReadMoreBox' => 'hide_read_more_box',
                'HideShareBox' => 'hide_share_box',
                'SurveyId' => 'poll_id',
                'EmbedSrc' => 'embed_src',
                'UpdateLinkedText' => 'update_linked_text',
                'Video_Content' => 'video_content',
            ],
        ],
        self::TABLE_COLLECTION_PAGE_LINKS => [
            self::LOCAL_TABLE_NAME => 'articles',
            self::COLUMNS => [
                'ArticleId' => 'id',
                'CollectionPageId' => 'collection_page_id',
            ],
        ],
        self::TABLE_MEDIA_ITEM => [
            self::LOCAL_TABLE_NAME => 'media_items',
            self::COLUMNS => [
                'MediaItemId' => 'id',
                'Created' => 'created_at',
                'FK_ImageId' => 'image_id',
                'Type' => 'media_item_type_id',
                'SortOrder' => 'sort_order',
                'ExtMediaId' => 'external_media_id',
                'Description' => 'description',
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

            DB::connection()->disableQueryLog();

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
                    $offset = 150000;
                    $sqlQuery = "SELECT {$productionColumns} FROM {$productionTable} ORDER BY {$productionPrimaryKey} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";
                    $this->info("\n\n{$sqlQuery}");

                    $this->info("TEST 1");

                    // while we get records from production, insert data to local
                    while ($results = DB::connection($connectionName)->select($sqlQuery)) {
                        $dataToInsert = [];
                        $this->info("TEST 2");

                        DB::beginTransaction();

                        foreach ($results as $result) {
                            // initiate data to insert
                            $data = [
                                'created_at' => Carbon::today()->format('Y-m-d'),
                                'updated_at' => Carbon::today()->format('Y-m-d'),
                            ];
                            $columnsToUpdate = array_values(self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS]);

                            foreach ($result as $productionColumn => $value) {
                                // set the local column name based on the production column name
                                $localColumn = self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS][$productionColumn];

                                // ignore record if its foreign keys does not exist in the related table
                                if (in_array($localColumn, array_keys($relatedTables))) {
                                    $foreignKeyExists = false;

                                    // if value is not null, then check foreign key id exist in the related table
                                    // if values is null then assert that foreign key does not exist
                                    if ($value) {
                                        $relatedLocalTable = $relatedTables[$localColumn];
                                        $sqlQueryRelatedTable = "SELECT id FROM {$relatedLocalTable} WHERE id = {$value}";
                                        $foreignKeyExists = DB::select($sqlQueryRelatedTable) ? true : false;
                                    }

                                    // if foreign key does not exist then
                                    if (!$foreignKeyExists) {
                                        // ignore record for specific foreign key columns, where the id does not exist in the relative table
                                        if (isset(self::IGNORE_RECORDS_FOR_SPECIFIC_FOREIGN_KEYS_WHERE_ID_DOES_NOT_EXIST[$productionTable])
                                            && in_array($productionColumn, self::IGNORE_RECORDS_FOR_SPECIFIC_FOREIGN_KEYS_WHERE_ID_DOES_NOT_EXIST[$productionTable])) {
                                            $data = [];

                                            break;
                                        // when the foreign key column is not listed in the constant variable, we keep the record and set its value to NULL
                                        } else {
                                            $value = null;
                                        }
                                    }
                                }

                                // ignore record when specific column has NULL value
                                if (isset(self::NULL_COLUMNS_TO_IGNORE_RECORD[$productionTable])
                                    && in_array($productionColumn, self::NULL_COLUMNS_TO_IGNORE_RECORD[$productionTable])
                                    && !$value) {
                                    $data = [];

                                    break;
                                }

                                // set NULL value for date columns with 1900-01-01 value
                                if (str_contains($value, '1900-01-01')) {
                                    $value = null;
                                }

                                // test test test test test test test
                                if ($productionTable === 'Image' && $productionColumn === 'Deleted') {
                                    if (!$value) {
                                        $value = null;
                                    } else {
                                        $value = Carbon::today()->format('Y-m-d');
                                    }
                                }

                                // cast values of boolean fields to boolean
                                if (isset(self::BOOLEAN_COLUMNS[$productionTable]) && in_array($productionColumn, self::BOOLEAN_COLUMNS[$productionTable])) {
                                    $value = (boolean) $value;
                                }

                                // set default value for specific column where its value is NULL
                                if (isset(self::DEFAULT_VALUES_ON_NULL_PER_COLUMN[$productionTable])
                                    && in_array($productionColumn, array_keys(self::DEFAULT_VALUES_ON_NULL_PER_COLUMN[$productionTable]))
                                    && !$value) {
                                    $value = self::DEFAULT_VALUES_ON_NULL_PER_COLUMN[$productionTable][$productionColumn];
                                }

                                // add values per column
//                                if ($value !== null) {
                                    $data[$localColumn] = $value;
//                                }
                            }

                            // insert or update data based on the unique columns
                            if ($data) {
                                $dataToInsert[] = $data;
                            }
                        }

                        $this->info("TEST 3");

                        // mass insert
                        DB::table($localTable)->upsert(
                            $dataToInsert,
                            self::UNIQUE_LOCAL_COLUMNS_PER_TABLE[$productionTable],   // local table unique columns
                            $columnsToUpdate,
//                            array_values(self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS])    // local table columns
                        );

                        DB::commit();

                        $this->info("TEST 4");
                        usleep(500000);
//                        sleep(1);

                        // increase offset to get the next batch of data
                        $offset += $limit;
                        $sqlQuery = "SELECT {$productionColumns} FROM {$productionTable} ORDER BY {$productionPrimaryKey} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";

                        $this->info("\n\n{$sqlQuery}");
                    }

                    ++$success;
                } catch (\Exception $e) {
                    DB::rollback();

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

    public function articlesData(array $data): array
    {


        return $reservations;
    }
}
