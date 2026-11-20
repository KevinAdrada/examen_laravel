<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $fillable = [
        'habitacion',
        'fecha',
        'doctor_id',
        'patient_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
