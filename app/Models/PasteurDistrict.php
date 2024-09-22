<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasteurDistrict extends Model
{
    use HasFactory;
    protected $fillable = [
        'dateDebut',
        'dateFin',
        'id_pst',
        'id_dist',
    ];
}
