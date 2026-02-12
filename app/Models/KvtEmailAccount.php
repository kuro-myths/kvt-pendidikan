<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KvtEmailAccount extends Model
{
    protected $fillable = [
        'user_id', 'school_id', 'kvt_email', 'display_name',
        'status', 'email_data', 'last_login_at',
    ];

    protected $casts = [
        'email_data' => 'array',
        'last_login_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
