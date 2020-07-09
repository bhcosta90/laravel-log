<?php

return [
    'name' => 'Log',
    'table' => env('LOG_TABLE', 'user_logs'),
    'driver' => env('LOG_DRIVER', 'database')
];
