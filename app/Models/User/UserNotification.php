<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'sender_id',
        'user_id',
        'read',
        'body',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isRead()
    {
        return $this->read;
    }

    public function notable()
    {
        return $this->morphTo();
    }
}
