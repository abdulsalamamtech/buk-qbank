<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'question',
        'answer',
        'options',
        'status',
        'course_id',
        'asset_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        // 'created_at' => 'datetime',
        // 'updated_at' => 'datetime',
        // 'deleted_at' => 'datetime',
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
