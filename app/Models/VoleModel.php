<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoleModel extends Model
{
    
    use HasFactory;
    protected $table = 'voles';
    protected $fillable = [
        'ville', 'destination_id', 'description', 'du', 'au', 'prix', 'image'
    ];

    public function destination()
    {
        return $this->belongsTo(DestinationModel::class);
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
