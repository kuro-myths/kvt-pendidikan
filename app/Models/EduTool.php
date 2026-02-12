<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EduTool extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'icon_url',
        'website_url',
        'claim_url',
        'category',
        'benefits',
        'how_to_claim',
        'requirements',
        'requires_kvt_email',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'benefits' => 'array',
        'requirements' => 'array',
        'requires_kvt_email' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_edu_tools')
            ->withPivot(['status', 'claimed_at', 'kvt_email_used', 'expires_at', 'notes'])
            ->withTimestamps();
    }

    public function claimedBy()
    {
        return $this->users()->wherePivot('status', 'aktif');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'development' => 'Development',
            'design' => 'Design',
            'productivity' => 'Produktivitas',
            'learning' => 'Pembelajaran',
            'cloud' => 'Cloud & Hosting',
            'communication' => 'Komunikasi',
            'ai' => 'AI & Machine Learning',
            default => ucfirst($this->category),
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'development' => 'from-green-500 to-emerald-600',
            'design' => 'from-pink-500 to-rose-600',
            'productivity' => 'from-blue-500 to-indigo-600',
            'learning' => 'from-yellow-500 to-amber-600',
            'cloud' => 'from-cyan-500 to-teal-600',
            'communication' => 'from-purple-500 to-violet-600',
            'ai' => 'from-orange-500 to-red-600',
            default => 'from-gray-500 to-gray-600',
        };
    }
}
