<?php

namespace BRCas\Log\Entities;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Log extends Model
{
    protected $fillable = [
        'url',
        'request',
        'response',
        'custom'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->id = (string)RamseyUuid::uuid4();
            if ($user = auth()->user()) {
                $obj->user_id = $user->id;
                $obj->user_name = $user->name;
                $obj->user_email = $user->email;
            }
        });
    }

    public function getTable()
    {
        return config('brcaslog.table', 'brcaslog_table');
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }

    public function setRequestAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->attributes['request'] = $value;
    }

    public function setResponseAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->attributes['response'] = $value;
    }

    public function setCustomAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->attributes['custom'] = $value;
    }
}
