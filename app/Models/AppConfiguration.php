<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'key',
        'value',
    ];

    public static function getValue($key, $organizationId = 1, $default = null)
    {
        $config = self::where('organization_id', $organizationId)
                     ->where('key', $key)
                     ->first();

        return $config ? $config->value : $default;
    }

    public static function setValue($key, $value, $organizationId = 1)
    {
        return self::updateOrCreate(
            [
                'organization_id' => $organizationId,
                'key' => $key,
            ],
            [
                'value' => $value,
            ]
        );
    }
}