<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateData extends Command
{
//    public const PRODUCTION_TABLE_NAME = 'production';
    public const LOCAL_TABLE_NAME = 'local_table_name';

    public const COLUMNS = 'columns';

    public const DATABASE_AD_MANAGEMENT = 'CY_AdManagement';
    public const DATABASE_BIG_FORUM = 'CY_BigForum';
    public const DATABASE_CONTENT = 'CY_Content';
    public const DATABASE_ERROR = 'CY_Error';
    public const DATABASE_FORUM = 'CY_Forum';
    public const DATABASE_MEMBER = 'CY_Member';
    public const DATABASE_SURVEY = 'CY_Survey';

    public const TABLE_ADMINUSER = 'AdminUser';

    public const DATATABLES = [
        self::DATABASE_CONTENT => [
            self::TABLE_ADMINUSER,
        ]
    ];

//    public const BOOLEAN_COLUMNS = [
//        'failed_login',
//        'locked',
//        'has_photo',
//        'show_email',
//    ];

    public const BOOLEAN_COLUMNS = [
        'Locked',
        'HasPhoto',
        'ShowEmail',
    ];

    public const NULL_COLUMNS_TO_IGNORE_RECORD = [
        self::TABLE_ADMINUSER => ['Password'],
    ];

    public const PRIMARY_KEY_PER_TABLE = [
        self::TABLE_ADMINUSER => 'AdminUserId',
    ];

    public const UNIQUE_COLUMNS_PER_TABLE = [
        self::TABLE_ADMINUSER => ['UserName'],
    ];

    public const MAPPING_PER_TABLE = [
        self::TABLE_ADMINUSER => [
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
        ]
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
//        $bar = $this->output->createProgressBar($parcels->count());
        $bar = $this->output->createProgressBar(1);
        $bar->start();

        $success = 0;
        $errors = 0;
        $offset = 0;
        $limit = 1000;

        try {
            $connectionName =  env('DB_CONNECTION2');
            $productionTable = self::TABLE_ADMINUSER;
            $localTable = self::MAPPING_PER_TABLE[$productionTable][self::LOCAL_TABLE_NAME];
            $primaryKey = self::PRIMARY_KEY_PER_TABLE[$productionTable];
            $productionColumns = implode(',', array_keys(self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS]));

            $sqlQuery = "SELECT {$productionColumns} FROM {$productionTable} ORDER BY {$primaryKey} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";

            $this->info("\n\n{$sqlQuery}");

            while ($results = DB::connection($connectionName)->select($sqlQuery)) {
                foreach ($results as $result) {
                    $data = [];
                    $uniqueData = [];

                    foreach ($result as $column => $value) {
                        if (in_array($column, self::NULL_COLUMNS_TO_IGNORE_RECORD[$productionTable]) && $value === null) {
                            $data = [];

                            break;
                        }

                        // set NULL value for date columns with 1900-01-01 value
                        if (str_contains($value, '1900-01-01')) {
                            $value = null;
                        }

                        // cast values of boolean fields to boolean
                        if (in_array($column, self::BOOLEAN_COLUMNS)) {
                            $value = (boolean) $value;
                        }

                        // add values per column
                        if (in_array($column, self::UNIQUE_COLUMNS_PER_TABLE[$productionTable])) {
                            $uniqueData[self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS][$column]] = $value;
                        } else {
                            $data[self::MAPPING_PER_TABLE[$productionTable][self::COLUMNS][$column]] = $value;
                        }
                    }

                    if ($data) {
                        if ($data['id'] == 3631) {
                            dd($data);
                        }

                        DB::table($localTable)->updateOrInsert(
                            $uniqueData,
                            $data
                        );
                    }
                }

//                User::insert($dataToInsert);

                $offset += $limit;
                $sqlQuery = "SELECT {$productionColumns} FROM {$productionTable} ORDER BY {$primaryKey} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";

                $this->info("\n\n{$sqlQuery}");
            }

            ++$success;
        } catch (\Exception $e) {
            $this->error("\n\nError: {$e->getMessage()}");

            ++$errors;
        }

        $bar->advance();

        $bar->finish();

        $this->info("\n\nSuccessful updates: {$success}");
        $this->error("Unsuccessful updates: {$errors}");
    }
}
