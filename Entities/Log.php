<?php

namespace BRCas\Log\Entities;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Log extends Model
{
    public function getTable()
    {
        return config('brcaslog.table');
    }
    protected $fillable = [
        'url',
        'request',
        'response',
        'custom'
    ];

    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->id = (string) RamseyUuid::uuid4();
            if($user = auth()->user()){
                $obj->user_id = $user->id;
                $obj->user_name = $user->name;
                $obj->user_email = $user->email;
            }
        });
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
