<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellidos',
        'imagen_url',
        'imagen_public_id',
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
