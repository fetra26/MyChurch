<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'datenais',
        'id_eglise',
        'id_stat',
    ];
    public function baptemes()
    {
        return $this->hasMany(Bapteme::class,'id_membre');
    }
    public function pstBaptemes()
    {
        return $this->hasMany(Bapteme::class,'id_pst');
    }
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function eglise(): BelongsTo
    {
        return $this->belongsTo(Eglise::class);
    }
    public function districts(): BelongsToMany
    {
        return $this->belongsToMany(District::class,'pasteur_districts', 'id_pst', 'id_dist')
                    ->withPivot('dateDebut', 'dateFin')
                    ->withTimestamps();
    }
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_membres', 'id_membre', 'id_serv')
                    ->withPivot('dateDebutServ', 'dateFinServ')
                    ->withTimestamps();
    }
}
