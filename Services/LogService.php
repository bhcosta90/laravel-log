<?php

namespace BRCas\Log\Services;

use BRCas\Log\Entities\Log;
use Illuminate\Support\Facades\Log as FacadesLog;

class LogService
{
    public static $save = true;
    private static $custom = [];

    public static function add($key, $value = null)
    {
        self::$custom[$key] = $value;
    }

    public function save(array $data)
    {
        if (count(self::$custom)) {
            $data += [
                'custom' => self::$custom,
            ];
        }

        if (self::$save === true) {
            switch (config('brcaslog.driver')) {
                case 'database':
                    Log::create($data);
                    break;
            }
        } else {
            FacadesLog::info(json_encode($data));
        }
    }
}
