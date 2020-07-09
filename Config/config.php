<?php

return [
    'name' => 'Log',
    'table' => env('LOG_TABLE', 'logs'),
    'driver' => env('LOG_DRIVER', 'database')
];
