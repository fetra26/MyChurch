<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eglise extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomEglise',
        'id_type',
        'id_cont',
        'id_dist',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_cont');
    }
    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'id_dist');
    }
    // Relationship for accessing members
    public function membres()
    {
        return $this->hasMany(Membre::class,'id_eglise');
    }
    public function responsables()
    {
        return $this->hasMany(User::class,'id_eglise')
        ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN]);
    }
  // Relationship for receiving transfers through the pivot table
    public function membresTransferts()
    {
        return $this->belongsToMany(Membre::class, 'transferts')
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
    // Relationship for receiving transfers (as source)
      // Relationship for transfers originating from this church
    public function sourceTransferts()
    {
        return $this->hasMany(Transfert::class, 'egliseSource_id');
    }

    // Relationship for receiving transfers (as destination)
    // Relationship for transfers destined to this church
    public function destinationTransferts()
    {
        return $this->hasMany(Transfert::class, 'egliseDest_id');
    }
}
