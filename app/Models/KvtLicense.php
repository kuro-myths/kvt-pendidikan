<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KvtLicense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'tipe_lisensi',
        'berlaku_mulai',
        'berlaku_sampai',
        'status',
        'max_guru',
        'max_siswa',
        'max_kelas',
        'catatan',
    ];

    protected $casts = [
        'berlaku_mulai' => 'date',
        'berlaku_sampai' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'aktif' && $this->berlaku_sampai >= now();
    }

    public function isExpired(): bool
    {
        return $this->berlaku_sampai < now();
    }

    public function sisaHari(): int
    {
        return max(0, now()->diffInDays($this->berlaku_sampai, false));
    }

    public static function getLimits(string $tipe): array
    {
        return match ($tipe) {
            'basic' => ['max_guru' => 10, 'max_siswa' => 100, 'max_kelas' => 5],
            'pro' => ['max_guru' => 50, 'max_siswa' => 500, 'max_kelas' => 20],
            'premium' => ['max_guru' => 200, 'max_siswa' => 2000, 'max_kelas' => 100],
            default => ['max_guru' => 10, 'max_siswa' => 100, 'max_kelas' => 5],
        };
    }
}
