<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'template_path',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public static function getDefault($organizationId = 1, $type = 'excel')
    {
        return self::where('organization_id', $organizationId)
                  ->where('type', $type)
                  ->where('is_default', true)
                  ->first();
    }

    public static function getByType($type, $organizationId = 1)
    {
        return self::where('organization_id', $organizationId)
                  ->where('type', $type)
                  ->get();
    }
}