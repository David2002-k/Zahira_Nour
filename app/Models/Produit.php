<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    protected $fillable = [
        'categorie_id',
        'photo',
        'nom',
        'slug',
        'description',
        'prix',
        'stock',
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
            'prix' => 'decimal:2',
            'stock' => 'integer',
            'date_publication' => 'datetime',
        ];
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function lignesCommande(): HasMany
    {
        return $this->hasMany(Ligne_commande::class, 'produit_id');
    }
}
