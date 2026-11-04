<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = [
        'client_id',
        'prenom',
        'nom',
        'email',
        'sujet',
        'contenu',
        'statut',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function reponses(): HasMany
    {
        return $this->hasMany(MessageReponse::class);
    }
}
