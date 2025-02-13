<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class tag extends Model
{
    use HasFactory,HasUuids;
    protected $guarded = ['id','created_at','updated_at'];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_tags', 'tag_id', 'task_id');
    }
}
