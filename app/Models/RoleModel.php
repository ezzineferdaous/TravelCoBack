<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = ['nom'];
    public function utilisateurs()
    {
        return $this->hasMany(UtilisateurModel::class);
    }
}
