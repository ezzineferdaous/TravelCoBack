<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationModel extends Model
{
    use HasFactory;
    protected $table = 'destinations';

    protected $fillable = ['nom'];

    public function voles()
    {
        return $this->hasMany(VoleModel::class);
    }

}