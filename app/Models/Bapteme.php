<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bapteme extends Model
{
    use HasFactory;
    protected $fillable = [
        'messageBapt',
        'certificat',
        'lieuBapt',
        'isCertDelivered',
        'dateBapt',
        'id_pst',
        'id_membre',
    ];

    public function membre()
    {
        return $this->belongsTo(Bapteme::class);
    }
    public function pasteur()
    {
        return $this->belongsTo(Bapteme::class);
    }

    // public static function rules()
    // {
    //     return [
    //         'tel' => 'required|unique:personnes,tel',
    //         'mail' => 'required|unique:personnes,mail',
    //     ];
    // }
    // public static $messages = [
    //     'tel.required' => 'Veuillez saisir le numéro de téléphone s\'il vous plait',
    //     'tel.unique' => 'Ce numéro de téléphone existe déjà',
    //     'mail.required' => 'Veuillez saisir l\'adresse e-mail s\'il vous plait',
    //     'mail.unique' => 'Cet adresse e-mail existe déjà',
    // ];
}
