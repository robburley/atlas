<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class PermissionType extends Model
{
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
