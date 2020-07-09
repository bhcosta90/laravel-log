<?php

namespace BRCas\Log\Services;

use BRCas\Log\Entities\Log;
use Illuminate\Support\Facades\Log as FacadesLog;

class LogService {
    private static $custom = [];
    public static $save = true;

    public static function add($key, $value=null){
        self::$custom[$key] = $value;
    }
    
    public function save(array $data){
        if(count(self::$custom)){
            $data += [
                'custom' => self::$custom,
            ];
        }

        if(self::$save === true){
            switch(config('brcaslog.driver')){
                case 'database':
                    Log::create($data);
                break;
            }
        } else {
            FacadesLog::info($data);
        }
    }
}