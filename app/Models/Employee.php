<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'age',
        'phone',
        'photo',
        'team_id',
        'role_id',
        'is_verified',
        'verified_at',
    ];

    /**
     * Get the team that owns the employee.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the role that owns the employee.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
