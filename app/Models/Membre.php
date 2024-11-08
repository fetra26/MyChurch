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

    // public static function membersWithService(array|string $serviceLabels)
    // {
    //     // Ensure the input is treated as an array
    //     $serviceLabels = (array) $serviceLabels;
    
    //     // Return a query builder with the condition applied
    //     return self::whereHas('services', function ($query) use ($serviceLabels) {
    //         foreach ($serviceLabels as $serviceLabel) {
    //             $query->orWhereRaw('LOWER(libelleServ) = ?', [strtolower($serviceLabel)]);
    //         }
    //     });
    // }
    // In app/Models/Membre.php

// In app/Models/Membre.php

public static function membersWithService(array|string $serviceLabels, $districtId = null, $egliseId = null)
{
    return self::where(function ($query) use ($serviceLabels, $districtId, $egliseId) {
        // Convert to array if it's a single string
        $serviceLabels = (array) $serviceLabels;

        // Check for services and filter accordingly
        if (in_array('Pasteur', $serviceLabels)) {
            // If 'Pasteur' is one of the services, filter by district
            $query->whereHas('services', function ($q) {
                $q->where('libelleServ', 'Pasteur');
            });

            if ($districtId) {
                // Filter by the district of the eglise
                $query->whereHas('eglise', function ($q) use ($districtId) {
                    $q->where('id_dist', $districtId);
                });
            }
        }

        if (in_array('Loholona', $serviceLabels)) {
            // If 'Loholona' is one of the services, filter by eglise
            $query->orWhereHas('services', function ($q) {
                $q->where('libelleServ', 'Loholona');
            });

            if ($egliseId) {
                // Filter by eglise id
                $query->where('id_eglise', $egliseId);
            }
        }
    })->get()->map(function ($member) {
        // Concatenate the service to the member's name
        $member->full_name = $member->services->pluck('libelleServ')->implode(', ') .' '.$member->nom .' '.$member->prenom;
        return $member;
    });
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
                        'source_pstOrLhl_name',
                        'destination_pstOrLhl_name'
                        )            
                    ->withTimestamps();
    }
// Relationship to access all transfers related to this member
    public function transferts()
    {
        return $this->hasMany(Transfert::class);
    }

        /**
     * Transfers where this member is the source 'Pasteur' or 'Loholona'
     */
    public function sourceTransferts()
    {
        return $this->hasMany(Transfert::class, 'source_pstOrLhl_id')
                    ->whereHas('services', function ($query) {
                        $query->whereIn('libelleServ', ['Pasteur', 'Loholona']);
                    });
    }

    /**
     * Transfers where this member is the destination 'Pasteur' or 'Loholona'
     */
    public function destinationTransferts()
    {
        return $this->hasMany(Transfert::class, 'destination_pstOrLhl_id')
                    ->whereHas('services', function ($query) {
                        $query->whereIn('libelleServ', ['Pasteur', 'Loholona']);
                    });
    }
}
