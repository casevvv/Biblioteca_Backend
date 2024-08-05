<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver that will be used by the
    | framework. The "bcrypt" and "argon" drivers are included with Laravel.
    | You may change this to any driver you prefer, but be sure to include
    | a suitable driver for your needs.
    |
    */

    'driver' => env('HASH_DRIVER', 'bcrypt'),

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may configure the options for the Bcrypt hashing algorithm that
    | is used by the Bcrypt driver. You may adjust the cost factor if needed.
    |
    */

    'bcrypt' => [
        'rounds' => 12,
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may configure the options for the Argon and Argon2i hashing
    | algorithms. You may adjust the time cost, memory cost, and threads
    | as needed to meet your application's security requirements.
    |
    */

    'argon' => [
        'driver' => 'argon2i',
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
    ],

];
