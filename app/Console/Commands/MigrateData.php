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

    public const COLUMNS_WITH_DEFAULT_VALUE = [
        'last_login' => null,
        'failed_login' => false,
        'locked' => false,
        'has_photo' => false,
        'show_email' => false,
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
//        foreach ($parcels as $parcel) {
            try {
//                $lol = $this->test('lol');

                $connectionName =  env('DB_CONNECTION2');
                $productionTable = self::TABLE_ADMINUSER;
                $productionColumns = implode(',', array_keys(self::MAPPING_PER_TABLE[self::TABLE_ADMINUSER][self::COLUMNS]));

                $sqlQuery = "SELECT TOP 1000 {$productionColumns} FROM {$productionTable}";

                $results = DB::connection($connectionName)->select($sqlQuery);

                $dataToInsert = [];
                foreach ($results as $result) {
                    foreach ($result as $column => $value) {
                        if (str_contains($value, '1900-01-01')) {
                            $value = null;
                        }

                        $data[self::MAPPING_PER_TABLE[self::TABLE_ADMINUSER][self::COLUMNS][$column]] = $value;
                    }

                    $dataToInsert[] = $data;
                }

//                dd($dataToInsert);



                User::insert($dataToInsert);








//                dd($results);


//                foreach ($results as $result) {

                    $values = [];
//                    foreach ($result as $value) {
//                        $values[] = $value;
//                    }

//                    $values = implode(',', $values);

//                    DB::connection('sqlsrv')->insert('insert into users (' . implode(',', self::MAPPING_PER_TABLE[self::TABLE_ADMINUSER][self::LOCAL_COLUMNS]) . ')
//                    values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [1, 'Marc']);







//                    DB::connection('sqlsrv')->unprepared('SET IDENTITY_INSERT user_roles ON');

//                    DB::connection('sqlsrv')->insert('insert into users (' . implode(',', self::MAPPING_PER_TABLE[self::TABLE_ADMINUSER][self::LOCAL_COLUMNS]) . ')
//                    values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $values);



//                    $data = [
//                        [
//                            'first_name' => 'Christos',
//                            'last_name' => 'Tsam',
//                            'email' => 'test@test.com',
//    //                'nickname',
//                            'username' => 'testUsername',
//                            'password' => 'test1234',
//                        ],
//                        [
//                            'first_name' => 'Christos2',
//                            'last_name' => 'Tsam2',
//                            'email' => 'test2@test.com',
//    //                'nickname',
//                            'username' => 'test2Username',
//                            'password' => 'test1234',
//                        ],
//                    ];
//
//                    User::insert([
//                        [
//                            'id' => 5,
//                            'first_name' => 'Christos',
//                            'last_name' => 'Börjesson',
//                            'email' => 'test@test.com',
//                            //                'nickname',
//                            'username' => 'testUsername',
//                            'password' => 'test1234',
//                        ],
//                        [
//                            'id' => 6,
//                            'first_name' => 'Djurgården',
//                            'last_name' => 'Börjesson2',
//                            'email' => 'test2@test.com',
//                            //                'nickname',
//                            'username' => 'test2Username',
//                            'password' => 'test1234',
//                        ],
//                    ]);






//                    DB::connection('sqlsrv')->insert('insert into users (' . implode(',', self::MAPPING_PER_TABLE[self::TABLE_ADMINUSER][self::LOCAL_COLUMNS]) . ')
//                    values (' . implode(',', $values) . ')');


//                    $test = ['christos', 'Börjesson', 'test@test.gr', 'username', 'test1234', 'nameTest'];

//                    DB::connection('sqlsrv')->insert('insert into users (' . implode(',', self::MAPPING_PER_TABLE[self::TABLE_ADMINUSER][self::LOCAL_COLUMNS]) . ')
//                    values (?, ?, ?, ?, ?)', $test);

//                    DB::connection('sqlsrv')->insert('insert into users (' . implode(',', self::MAPPING_PER_TABLE[self::TABLE_ADMINUSER][self::LOCAL_COLUMNS]) . ')
//                    values (' . implode(',', $test) . ')');


//                    DB::connection('sqlsrv')->unprepared('SET IDENTITY_INSERT user_roles OFF');


//                    dd($result);
//                }







                // Your raw SQL query
//                $sqlQuery = 'USE CY_Content; SELECT TOP 1 * FROM AdminUsers;';
//                $sqlQuery = 'SELECT TOP 1 * FROM AdminUser';
//                $sqlQuery = 'SELECT * FROM AdminUsers';
//                $sqlQuery = 'SHOW TABLES';

//                $results = DB::connection($connectionName)->select($sqlQuery);


//                $tables = DB::connection($connectionName)->select("SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE'");


//                dd($tables);


//                DB::select('SHOW TABLES');


                // Execute the query on the specified connection

                // Process the results as needed
//                foreach ($results as $result) {
//
//                    $tableColumn = 'id';
//
//
//                    dd($result->$tableColumn);
//
//                    // Process each result
//                }


                ++$success;
            } catch (\Exception $e) {

                dd('Error: ' . $e->getMessage());

//                $this->logger->error("Parcel {$parcel->id} failed", [$e->getMessage()]);
                ++$errors;
            }

            $bar->advance();
//        }

        $bar->finish();

        $this->info("\n\nSuccessful updates: {$success}");
        $this->error("Unsuccessful updates: {$errors}");
    }


    /**
     * Migrate
     *
     * @param string $parcel
     *
     * @return string
     */
    private function test(string $test): string
    {

        return $test;

        // update only parcels with orgm > 3 and soil type not null
        // or with null soil_type
//        if ($parcel->soilProperties->orgm > static::MINIMUM_ACCEPTABLE_ORGM || null == $parcel->soilProperties->soil_type) {
//            // start db transaction
//            DB::beginTransaction();
//
//            try {
//                // get new soil properties
//                $soilProperties = SoilGrids::get($parcel->coordinates['lon'], $parcel->coordinates['lat']);
//                // update parcel soil properties
//                $parcel->soilProperties->update($soilProperties);
//                $parcel->save();
//            } catch (\Exception $e) {
//                // something went wrong, rollback and throw same exception
//                DB::rollBack();
//
//                throw $e;
//            }
//
//            // commit database changes
//            DB::commit();
//        }
    }


    /**
     * Migrate
     *
     * @param string $parcel
     *
     * @return array
     */
    private function mapping(string $test): array
    {

        $mapping = [
            'CY_Content' => [
                [
                  'table_name' => '',
                  'table_columns' => '',
                ],
                'AdminUser' => [
                    'production' => [],
                    '' => [],
                ]
            ]


        ];



    }


}
