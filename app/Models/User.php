<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'isBanned',
        'isAdmin',
        'reputation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'isBanned' => 'boolean',
            'isAdmin' => 'boolean',
        ];
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function colocations()
    {
        return $this->belongsToMany(Colocation::class, 'memberships')
            ->using(Membership::class) 
            ->withPivot('role', 'joined_at', 'left_at')
            ->withTimestamps();
    }
    public function isAdmin(): bool
    {
        return (bool) $this->isAdmin;
    }

    public function createdColocations()
    {
        return $this->hasMany(Colocation::class, 'created_by');
    }

    public function expensesPaid()
    {
        return $this->hasMany(Expense::class, 'payer_id');
    }

    public function invitationsSent()
    {
        return $this->hasMany(Invitation::class, 'invited_by');
    }

    public function paymentsSent()
    {
        return $this->hasMany(Payment::class, 'from_user_id');
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'to_user_id');
    }
}
