<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'birth_date',
        'gender',
        'address',
        'blood_type',
        'emergency_contact',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Accessors
    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }
        
        try {
            return $this->birth_date->age;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('d F Y') : null;
    }

    // Generate patient ID
    public static function generatePatientId()
    {
        $lastPatient = self::latest('id')->first();
        $number = $lastPatient ? intval(substr($lastPatient->patient_id, 3)) + 1 : 1;
        return 'RSH' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}