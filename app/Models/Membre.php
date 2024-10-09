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
        'id_cont'
    ];
    public function baptemes()
    {
        return $this->hasMany(Bapteme::class,'id_membre');
    }
    public function pstBaptemes()
    {
        return $this->hasMany(Bapteme::class,'id_pst');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class,'id_cont');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'id_stat');
    }
    public function eglise()
    {
        return $this->belongsTo(Eglise::class, 'id_stat');
    }
    public function districts()
    {
        return $this->belongsToMany(District::class,'pasteur_districts', 'id_pst', 'id_dist')
                    ->withPivot('dateDebut', 'dateFin')
                    ->withTimestamps();
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_membres', 'id_membre', 'id_serv')
                    ->withPivot('dateDebutServ', 'dateFinServ')
                    ->withTimestamps();
    }
}
