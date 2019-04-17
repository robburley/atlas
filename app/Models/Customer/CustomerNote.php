<?php

namespace App\Models\Customer;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_note_type_id',
        'body',
        'pinned',
        'notable_id',
        'notable_type',
        'user_id',
        'active'
    ];

    /**
     * Get the type for the note.
     */
    public function type()
    {
        return $this->belongsTo(CustomerNoteType::class, 'customer_note_type_id');
    }

    /**
     * Get the user who created the note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function notable()
    {
        return $this->morphTo();
    }
}
