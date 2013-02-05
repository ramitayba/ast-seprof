<?php

/**
 * This is the Settings
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */

/**
 * 
 * Define Databases
 * 
 */
$databases = array(
    'database' => 'pos_back',
    'username' => '',
    'password' => '',
    'host' => '.\SQLEXPRESS',
    'port' => '',
    'driver' => '',
    'prefix' => '',
);

/**
 * 
 * Routes
 * 
 */
$routes = array(
    'usersController' => array('login', 'logout', 'users/index', 'users/usersform'),
    'rolesController' => array('users/roles', 'users/rolesform'),
    'categoriesController' => array('products/categories', 'products/categoriesform'),
    'itemsController' => array('products/items', 'products/itemsform'),
    'posController' => array('cafeterias/pos', 'cafeterias/posform'),
    'cafeteriasController' => array('cafeterias/index', 'cafeterias/cafeteriasform'),
    'eventsController' => array('events/index', 'events/add'),
    'allowancesController' => array('settings/allowance'),
    'erpController' => array('settings/erp'),
    'synchronizeController' => array('settings/manual', 'settings/automatic'),
    'reportsController' => array('reports/cafeteria-balance', 'reports/users-purchases',
        'reports/detailed-users-purchases', 'reports/purchased-inventory',
        'reports/events-listing', 'reports/menu-report', 'reports/detailed-event'),
);

/**
 * 
 * Actions
 * 
 */
$actions = array('add', 'edit', 'delete');
/**
 * 
 * Define error
 * 
 */

$error = array(
    '1' => array('01002','Disconnect error'),
    '2' => array('01004','Data truncated'),
    '3' => array('01S00','Invalid connection string attribute'),
    '4' => array('07001','Wrong number of parameters'),
    '5' => array('07002','Mismatching parameters'),
    '6' => array('08000','Connection exception'),
    '7' => array('08003','Connection not open'),
    '8' => array('08007','Connection failure during transaction'),
    '9' => array('21S01','Insert value list does not match column list'),
    '10' => array('22001','String data, right truncation'),
    '11' => array('22003','Numeric value out of range'),
    '12' => array('22007','Invalid datetime format'),
    '13' => array('22026','String data, length mismatch'),
    '14' => array('23000','Integrity constraint violation'),
    '15' => array('HY002','Invalid column number'),
    '16' => array('HY004','Invalid SQL Data type')
);
/**
 * 
 * Define status
 * 
 */
define('ACTIVE', 1);
define('DESACTIVE', 2);
define('DELETED', 3);
define('UNDER_PROCESSING', 4);
define('APPROVED', 5);
define('REJECTED', 6);
define('DEFAULT_COLOR', '#000000');

/**
 * 
 * 
 * define role
 * 
 */
define('ADMINISTRATOR', 1);
define('SUPERVISOR', 2);
define('OPERATOR', 3);
define('MANAGER', 4);


/**
 * Some distributions of Linux (most notably Debian) ship their PHP
 * installations with garbage collection (gc) disabled. Since SEProf depends on
 * PHP's garbage collection for clearing sessions, ensure that garbage
 * collection occurs by using the most common settings.
 */
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);

/**
 * Set session lifetime (in seconds), i.e. the time from the user's last visit
 * to the active session may be deleted by the session garbage collector. When
 * a session is deleted, authenticated users are logged out, and the contents
 * of the user's $_SESSION variable is discarded.
 */
ini_set('session.gc_maxlifetime', 200000);

/**
 * Set session cookie lifetime (in seconds), i.e. the time from the session is
 * created to the cookie expires, i.e. when the browser is expected to discard
 * the cookie. The value 0 means "until the browser is closed".
 */
ini_set('session.cookie_lifetime', 2000000);


// Turn off all error reporting
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Reporting E_NOTICE can be good too (to report uninitialized
// variables or catch variable name misspellings ...)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Report all errors except E_NOTICE
// This is the default value set in php.ini
error_reporting(E_ALL ^ E_NOTICE);

// Report all PHP errors (see changelog)
error_reporting(E_ALL);

// Report all PHP errors
error_reporting(-1);

// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

 //ini_set('display_errors','off');

