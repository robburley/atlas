<?php

namespace App\Models\Dxi;


use Illuminate\Database\Eloquent\Model;

class DxiCall extends Model
{
    protected $fillable = [
        'id',
        'callid',
        'qid',
        'dataset',
        'urn',
        'agent',
        'ddi',
        'cli',
        'ringtime',
        'duration',
        'result',
        'outcome',
        'type',
        'datetime',
        'answer',
        'disconnect',
        'last_update',
        'carrier',
        'flags',
        'terminate',
        'customer',
        'day'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'datetime',
        'answer',
        'disconnect',
        'last_update',
        'day',
    ];

    public function agent()
    {
        return $this->belongsTo(DxiAgent::class, 'agent', 'agent_id');
    }
}
