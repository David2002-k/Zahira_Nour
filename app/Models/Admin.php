<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $fillable = [
        'user_id',
        'biographie',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messageReponses(): HasMany
    {
        return $this->hasMany(MessageReponse::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function reseauxSociaux(): HasMany
    {
        return $this->hasMany(ReseauSocial::class);
    }
}
