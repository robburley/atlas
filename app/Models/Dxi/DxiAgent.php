<?php

namespace App\Models\Dxi;


use Illuminate\Database\Eloquent\Model;

class DxiAgent extends Model
{
    protected $fillable = [
        'id',
        'agent_id',
        'name',
        'branch',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function logins()
    {
        return $this->hasMany(DxiLogin::class, 'agent_id', 'agent_id');
    }

    public function calls()
    {
        return $this->hasMany(DxiCall::class, 'agent', 'agent_id');
    }
}
