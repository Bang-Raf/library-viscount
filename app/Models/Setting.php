<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getJamOperasional() {
        $json = static::getValue('jam_operasional', '{}');
        return json_decode($json, true);
    }

    public static function setJamOperasional($data) {
        static::updateOrCreate(['key' => 'jam_operasional'], ['value' => json_encode($data)]);
    }

    public static function getValue($key, $default = null) {
        $row = static::where('key', $key)->first();
        return $row ? $row->value : $default;
    }
} 