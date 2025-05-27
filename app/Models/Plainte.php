<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plainte extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'plaintes';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'statut',
        'piece_jointe',
        'date',
        'heure',
        'reponse',
        'motif_refus',
        'notification',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'heure' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur qui a créé la plainte.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
