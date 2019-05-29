<?php

/*
 * Application Dir location
 */

define('BASEPATH', dirname(__FILE__).'/');
ini_set('display_errors', 1);
/*
 * PHP Detect line endings for MAC files
 */
if (! ini_get("auto_detect_line_endings")) {
    ini_set("auto_detect_line_endings", '1');
}

require_once __DIR__.'/vendor/autoload.php';

/*
 * dd helper bootstrapping
 */
require __DIR__.'/vendor/larapack/dd/src/helper.php';

/*
 * Environment config management bootstrapping
 */
$dotenv = new Dotenv\Dotenv(__DIR__);

$dotenv->load();

/*
 * Database connection bootstrapping
 */

use Illuminate\Database\Capsule\Manager as Database;
    use Yajra\Oci8\Connectors\OracleConnector as Connector;

$database = new Database;

registerOracleDriver();

$database->addConnection([
    'name' => 'oracle',
    'driver' => 'oracle',
    'host' => env('ORACLE_DB_HOST', ''),
    'port' => env('ORACLE_DB_PORT', '1521'),
    'database' => env('ORACLE_DB_SID', ''),
    'service_name' => '',
    'username' => env('ORACLE_DB_USERNAME', ''),
    'password' => env('ORACLE_DB_PASSWORD', ''),
    'charset' => env('ORACLE_DB_CHARSET', 'AL32UTF8'),
    'prefix' => env('ORACLE_DB_PREFIX', ''),
], 'oracle');

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$database->setEventDispatcher(new Dispatcher(new Container));

$database->bootEloquent();

$database->setAsGlobal();


function registerOracleDriver() {
    \Illuminate\Database\Connection::resolverFor('oracle', function ($connection, $database, $prefix, $config) {
        $connector = new Connector();
        $connection = $connector->connect($config);
        $db = new \Yajra\Oci8\Oci8Connection($connection, $database, $prefix, $config);
        if (!empty($config['skip_session_vars'])) {
            return $db;
        }
        // set oracle session variables
        $sessionVars = [
            'NLS_TIME_FORMAT'         => 'HH24:MI:SS',
            'NLS_DATE_FORMAT'         => 'YYYY-MM-DD HH24:MI:SS',
            'NLS_TIMESTAMP_FORMAT'    => 'YYYY-MM-DD HH24:MI:SS',
            'NLS_TIMESTAMP_TZ_FORMAT' => 'YYYY-MM-DD HH24:MI:SS TZH:TZM',
            'NLS_NUMERIC_CHARACTERS'  => '.,',
        ];
        // Like Postgres, Oracle allows the concept of "schema"
        if (isset($config['schema'])) {
            $sessionVars['CURRENT_SCHEMA'] = $config['schema'];
        }
        if (isset($config['session'])) {
            $sessionVars = array_merge($sessionVars, $config['session']);
        }
        if (isset($config['edition'])) {
            $sessionVars = array_merge(
                $sessionVars,
                ['EDITION' => $config['edition']]
            );
        }
        $db->setSessionVars($sessionVars);

        return $db;
        
    });
}
