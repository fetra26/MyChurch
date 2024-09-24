<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelleServ'
    ];
    public function membres(): BelongsToMany
    {
        return $this->belongsToMany(Membre::class, 'service_membres', 'id_membre', 'id_serv')
                    ->withPivot('dateDebutServ', 'dateFinServ')
                    ->withTimestamps();
    }
}
