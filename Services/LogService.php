<?php

namespace BRCas\Log\Services;

use BRCas\Log\Entities\Log;

class LogService {
    private static $custom;

    public static function add($key, $value=null){
        self::$custom[$key] = $value;
    }
    
    public function save(array $data){
        if(count(self::$custom)){
            $data += [
                'custom' => self::$custom,
            ];
        }

        switch(config('brcaslog.driver')){
            case 'database':
                Log::create($data);
            break;
        }
    }
}