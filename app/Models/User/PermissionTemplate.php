<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class PermissionTemplate extends Model
{
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
