<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReseauSocial extends Model
{
    protected $table = 'reseaux_sociaux';

    protected $fillable = [
        'admin_id',
        'nom',
        'url',
        'icone',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
