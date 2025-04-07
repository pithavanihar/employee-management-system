<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;


class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'department_id',
        'name',
        'dob',
        'phone',
        'email',
        'salary',
        'status',
        'photo',
        'created',
        'modified',
    ];

    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
