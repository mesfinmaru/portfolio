<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'tags',
        'description',
        'code_snippet',
        'link_type',
        'link_url',
        'link_label',
        'sort_order',
    ];

    protected $casts = [
        'tags'         => 'array',
        'code_snippet' => 'array',
    ];

    /**
     * Map DB columns → Vue data shape.
     */
    public function toVueArray(): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'tags'        => $this->tags        ?? [],
            'desc'        => $this->description,
            'codeSnippet' => $this->code_snippet ?? [],
            'linkType'    => $this->link_type,
            'linkUrl'     => $this->link_url    ?? '',
            'linkLabel'   => $this->link_label  ?? '',
        ];
    }
}