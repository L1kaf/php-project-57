<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Label[] $labels
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id'
    ];

    public function status(): HasOne
    {
        return $this->hasOne(TaskStatus::class, 'id', 'status_id');
    }

    public function createdByUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }

    public function assignedToUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'assigned_to_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_label', 'task_id', 'label_id');
    }
}
