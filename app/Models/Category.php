<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon'];

    public function workerProfiles()
    {
        return $this->hasMany(WorkerProfile::class);
    }
}
