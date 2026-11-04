<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    protected $fillable = [
        'client_id',
        'numero_commande',
        'montant_total',
        'statut',
        'adresse_livraison',
        'telephone_livraison',
        'date_commande',
    ];

/**
 * Obtenir les attributs qui doivent être convertis (castés).
 *
 * @return array<string, string>
 */
    protected function casts(): array
    {
        return [
            'montant_total' => 'decimal:2',
            'date_commande' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function lignesCommande(): HasMany
    {
        return $this->hasMany(Ligne_commande::class, 'commande_id');
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}
