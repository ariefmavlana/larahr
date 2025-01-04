<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'logo',
    ];

    /**
     * Get the users for the company.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the teams for the company.
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get the roles for the company.
     */
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
