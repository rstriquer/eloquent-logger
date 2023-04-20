<?php

return [
    'logger' => [
        /**
         * Turns off logging while the value is false.
         */
        'active' => env('DB_LOGGER_ACTIVE', false),
        /**
         * The log file name to use from within storage/logs directory.
         */
        'file' => env('DB_LOGGER_FILE', '/logs/query.log'),
    ],
];
