<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrera extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }
}