<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentaireModel extends Model
{
    use HasFactory;

    protected $table = 'commentaires';
    protected $fillable = [
        'utilisateur_id', 'vole_id', 'message', 'date_comm'
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
