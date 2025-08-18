<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'code',
        'level',
        'department_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Get the user that created the department.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that last updated the department.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user that deleted the department.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    } 
}
