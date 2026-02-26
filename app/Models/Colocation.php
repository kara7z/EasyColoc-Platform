<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by'
    ];
    public function memberships()
    {
        return $this->hasMany(\App\Models\Membership::class);
    }

    public function members()
    {
        return $this->belongsToMany(\App\Models\User::class, 'memberships')
            ->withPivot('role', 'joined_at', 'left_at')
            ->withTimestamps();
    }
}
