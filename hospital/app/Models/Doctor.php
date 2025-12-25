<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'name',
        'specialty',
        'consultation_fee',
        'experience_years',
        'description',
        'skills',
        'color',
        'is_active',
    ];

    protected $casts = [
        'skills' => 'array',
        'consultation_fee' => 'integer',
        'experience_years' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getFormattedFeeAttribute()
    {
        return 'Rp ' . number_format($this->consultation_fee, 0, ',', '.');
    }

    // Generate doctor ID
    public static function generateDoctorId()
    {
        $lastDoctor = self::latest('id')->first();
        $number = $lastDoctor ? intval(substr($lastDoctor->doctor_id, 3)) + 1 : 1;
        return 'DOC' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}