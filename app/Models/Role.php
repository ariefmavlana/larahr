<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_id',
    ];

    /**
     * Get the company that owns the role.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the responsibilities for the role.
     */
    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class);
    }

    /**
     * Get the employees for the role.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
