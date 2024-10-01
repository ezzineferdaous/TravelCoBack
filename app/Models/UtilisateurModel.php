<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class UtilisateurModel extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    protected $table = 'utilisateurs';
    protected $fillable = [
        'nom', 'prenom', 'email', 'tel', 'date_naissance', 'password', 'role_id'
    ];

    public function role()
    {
        return $this->belongsTo(RoleModel::class);
    }
    public function reserves()
    {
        return $this->hasMany(ReserveModel::class);
    }
    public function commentaires()
    {
        return $this->hasMany(CommentaireModel::class);
    }
}
