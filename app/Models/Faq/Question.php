<?php

namespace App\Models\Faq;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'question'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
