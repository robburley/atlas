<?php

namespace App\Models\Customer;

use App\Models\User\Permission;
use Illuminate\Database\Eloquent\Model;

class CustomerFileType extends Model
{
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
