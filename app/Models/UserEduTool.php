<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEduTool extends Model
{
    protected $table = 'user_edu_tools';

    protected $fillable = [
        'user_id',
        'edu_tool_id',
        'kvt_email_used',
        'status',
        'claimed_at',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eduTool()
    {
        return $this->belongsTo(EduTool::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'aktif' && ($this->expires_at === null || $this->expires_at->isFuture());
    }
}
