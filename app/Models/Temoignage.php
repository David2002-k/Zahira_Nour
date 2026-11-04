<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Temoignage extends Model
{
    protected $fillable = [
        'client_id',
        'contenu',
        'statut',
        'date_publication',
    ];

/**
 * Obtenir les attributs qui doivent être convertis (castés).
 *
 * @return array<string, string>
 */
    protected function casts(): array
    {
        return [
            'date_publication' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
