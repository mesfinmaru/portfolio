<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioSetting extends Model
{
    protected $table = 'portfolio_settings';

    protected $fillable = ['section', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get a section's data array, or null if not found.
     */
    public static function getSection(string $section): ?array
    {
        $row = static::where('section', $section)->first();
        return $row?->data;
    }

    /**
     * Create or update a section's data.
     */
    public static function setSection(string $section, array $data): array
    {
        $row = static::updateOrCreate(
            ['section' => $section],
            ['data'    => $data]
        );
        return $row->data;
    }
}