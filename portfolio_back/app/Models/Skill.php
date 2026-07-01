<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'category',
        'icon',
        'icon_color',
        'label',
        'sort_order',
    ];

    /**
     * Map DB columns → Vue data shape.
     */
    public function toVueArray(): array
    {
        return [
            'id'        => $this->id,
            'icon'      => $this->icon,
            'iconColor' => $this->icon_color,
            'label'     => $this->label,
        ];
    }
}