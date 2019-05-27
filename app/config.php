<?php

/**
 * Base URI
 */
defined(BASE) or
define(
    BASE,
    "http://localhost/assessment-backend/"
);

/**
 * Assets URI
 */
defined(ASSETS) or
define(
    ASSETS,
    "http://localhost/assessment-backend/"
);

/**
 * Database configuation
 */
defined(DATABASE) or
define(
    DATABASE,
    [
        'DRIVER'    => 'mysql',
        'HOST'      => 'localhost',
        'NAME'      => 'desafio',
        'USER'      => 'maikel',
        'PASS'      => 'maikel',
        'CHARSET'   => 'utf8',
        'COLLATION' => 'utf8_unicode_ci',
        'PREFIX'    => '',
    ]
);

defined(DEBUG) or
define(DEBUG, false);
