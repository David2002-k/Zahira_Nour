<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = [
        'admin_id',
        'commande_id',
        'reference_paiement',
        'montant_paye',
        'mode_paiement',
        'date_paiement',
        'statut',
        'fichier_recu',
    ];

/**
 * Obtenir les attributs qui doivent être convertis (castés).
 *
 * @return array<string, string>
 */
    protected function casts(): array
    {
        return [
            'montant_paye' => 'decimal:2',
            'date_paiement' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
