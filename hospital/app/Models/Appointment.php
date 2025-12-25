<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'complaints',
        'status',
        'consultation_fee',
        'check_in_time',
        'check_out_time',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'cancelled_at' => 'datetime',
        'consultation_fee' => 'integer',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', Carbon::today());
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('d F Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->appointment_time->format('H:i');
    }

    public function getFormattedFeeAttribute()
    {
        return 'Rp ' . number_format($this->consultation_fee, 0, ',', '.');
    }

    // Status helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    // Generate appointment ID
    public static function generateAppointmentId()
    {
        $lastAppointment = self::latest('id')->first();
        $number = $lastAppointment ? intval(substr($lastAppointment->appointment_id, 3)) + 1 : 1;
        return 'RSH' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}