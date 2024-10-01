<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveModel extends Model
{
    use HasFactory;

    protected $table = 'reserves';
    protected $fillable = [
        'utilisateur_id', 'vole_id', 'Date_res'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(UtilisateurModel::class);
    }
    public function vole()
    {
        return $this->belongsTo(VoleModel::class);
    }
    
}
