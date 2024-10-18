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
        return $this->belongsTo(Eglise::class, 'id_eglise');
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
                    ->withPivot('dateDebutServ', 'dateFinServ','id_role')
                    ->withTimestamps();
    }

    public function hasService(string $serviceLabel): bool
    {
        return $this->services()->where('services.libelleServ', $serviceLabel)->exists();
    }

    public static function membersWithService(string $serviceLabel)
    {
        return self::whereHas('services', function ($query) use ($serviceLabel) {
            $query->where('libelleServ', $serviceLabel);
        })->get();
    }
    // Relationship to access the churches through transfers
    public function eglisesTransferts()
    {
        return $this->belongsToMany(Eglise::class, 'transferts')
                    ->withPivot(
                        'date_demande_transfert', 
                        'date_reponse_demande', 
                        'status', 
                        'source_responsable_id', 
                        'destination_responsable_id',
                        'eglise_name',
                        'membre_name',
                        'egliseSource_name',
                        'egliseDest_name',
                        'source_responsable_name',
                        'destination_responsable_name',
                        )            
                    ->withTimestamps();
    }
// Relationship to access all transfers related to this member
    public function transferts()
    {
        return $this->hasMany(Transfert::class);
    }
}
