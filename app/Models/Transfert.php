<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfert extends Model
{
    use HasFactory;
    protected $fillable = ['egliseSource_id', 'egliseDest_id', 'membre_id', 'source_responsable_id', 'destination_responsable_id', 'date_reponse_demande', 'status'];
// Relationship to the source church
    public function egliseSource()
    {
        return $this->belongsTo(Eglise::class,'egliseSource_id');
    }
      // Relationship to the destination church
    public function egliseDest()
    {
        return $this->belongsTo(Eglise::class,'egliseDest_id');
    }
 // Relationship to the member involved in the transfer
    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
// Relationship to the user who initiated the transfer
    public function sourceResponsable()
    {
        return $this->belongsTo(User::class, 'source_responsable_id');
    }
 // Relationship to the user who validated the transfer
    public function destinationResponsable()
    {
        return $this->belongsTo(User::class, 'destination_responsable_id');
    }
}
