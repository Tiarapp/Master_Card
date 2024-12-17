<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        // 'sqlsrv' => [
        //     'driver' => 'sqlsrv',
        //     'host' => env('DB_HOST2', 'SPASVR'),
        //     'port'     => env('DB_PORT2', '1433'),
        //     'database' => env('DB_DATABASE2', 'blog'),
        //     'username' => env('DB_USERNAME2', 'itspa18'),
        //     'password' => env('DB_PASSWORD2', 'spaAdmin'),
        //     'charset'  => env('DB_CHARSET', 'UTF8'),
        //     'prefix' => '',
        // ],

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'fbteknik' => [
            'driver'   => 'firebird',
            'host'     => env('DB_HOST1', '192.168.1.250'),
            'port'     => env('DB_PORT1', '3050'),
            'database' => env('DB_DATABASE1', 'D:\Database\FBDB\TEKNIK_INDUK_SPA.FDB'),
            'username' => env('DB_USERNAME1', 'sysdba'),
            'password' => env('DB_PASSWORD1', 'masterkey'),
            'charset'  => env('DB_CHARSET', 'UTF8'),
            'version'  => env('DB_VERSION', '2.5'), // Supported versions: 2.5, 1.5
            'role'     => null,
        ],

        'mysql2' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST2', '192.168.1.250'),
            'port' => env('DB_PORT2', '3306'),
            'database' => env('DB_DATABASE2', 'spa-24'),
            'username' => env('DB_USERNAME2', 'root'),
            'password' => env('DB_PASSWORD2', 'spa2023'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'fbbp' => [
            'driver'   => 'firebird',
            'host'     => env('DB_HOST3', '192.168.1.250'),
            'port'     => env('DB_PORT3', '3050'),
            'database' => env('DB_DATABASE3', 'D:\Database\FBDB\BP_CONVERTING_SPA.FDB'),
            'username' => env('DB_USERNAME3', 'sysdba'),
            'password' => env('DB_PASSWORD3', 'masterkey'),
            'charset'  => env('DB_CHARSET', 'UTF8'),
            'version'  => env('DB_VERSION', '2.5'), // Supported versions: 2.5, 1.5
            'role'     => null,
        ],

        'firebird' => [
            'driver'   => 'firebird',
            'host'     => env('DB_HOST4', '192.168.1.250'),
            'port'     => env('DB_PORT4', '3050'),
            'database' => env('DB_DATABASE4', 'D:\Database\FBDB\MASTER_SPA.FDB'),
            'username' => env('DB_USERNAME4', 'sysdba'),
            'password' => env('DB_PASSWORD4', 'masterkey'),
            'charset'  => env('DB_CHARSET', 'UTF8'),
            'version'  => env('DB_VERSION', '2.5'), // Supported versions: 2.5, 1.5
            'role'     => null,
        ],
        
        // 'firebird2' => [
        //     'driver'   => 'firebird',
        //     'host'     => env('DB_HOST5', '192.168.1.250'),
        //     'port'     => env('DB_PORT5', '3050'),
        //     'database' => env('DB_DATABASE5', 'D:\Database\FBDB\BJ_CONVERTING_SPA-NEW.FDB'),
        //     'username' => env('DB_USERNAME5', 'sysdba'),
        //     'password' => env('DB_PASSWORD5', 'masterkey'),
        //     'charset'  => env('DB_CHARSET', 'UTF8'),
        //     'version'  => env('DB_VERSION', '2.5'), // Supported versions: 2.5, 1.5
        //     'role'     => null,
        //     'options' => array(
        //     PDO::ATTR_PERSISTENT => false,
        //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //     PDO::ATTR_AUTOCOMMIT => false,
        //     )
        // ],
        
        'firebird2' => [
            'driver'   => 'firebird',
            'host'     => env('DB_HOST5', '192.168.1.250'),
            'port'     => env('DB_PORT5', '3050'),
            'database' => env('DB_DATABASE5', 'D:\Database\FBDB\BJ_CONVERTING_SPA.FDB'),
            'username' => env('DB_USERNAME5', 'sysdba'),
            'password' => env('DB_PASSWORD5', 'masterkey'),
            'charset'  => env('DB_CHARSET', 'UTF8'),
            'version'  => env('DB_VERSION', '2.5'), // Supported versions: 2.5, 1.5
            'role'     => null,
            'options' => array(
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_AUTOCOMMIT => false,
            )
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'mc_live'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],


        // 'tes2' => [
        //     'driver' => 'mysql',
        //     'url' => env('DATABASE_URL'),
        //     'host' => env('DB_HOST', '180.178.100.42'),
        //     'port' => env('DB_PORT', '3306'),
        //     'database' => env('DB_DATABASE', 'spa-23'),
        //     'username' => env('DB_USERNAME', 'spa23'),
        //     'password' => env('DB_PASSWORD', 'spa2023'),
        //     'unix_socket' => env('DB_SOCKET', ''),
        //     'charset' => 'utf8mb4',
        //     'collation' => 'utf8mb4_unicode_ci',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        //     'strict' => false,
        //     'engine' => null,
        //     'options' => extension_loaded('pdo_mysql') ? array_filter([
        //         PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        //     ]) : [],
        // ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST6', '192.168.1.250'),
            'port' => env('DB_PORT6', '1433'),
            'database' => env('DB_DATABASE6', 'Lauta_be_SPA'),
            'username' => env('DB_USERNAME6', 'itspa18'),
            'password' => env('DB_PASSWORD6', 'spaAdmin'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'options' => [
                'Database' => env('DB_DATABASE', 'Lauta_be_SPA'),
                'TrustServerCertificate' => true, // Jika SQL Server menggunakan self-signed certificate
                'ODBCDriver' => 'ODBC Driver 17 for SQL Server', // Pastikan versi driver di sini
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
