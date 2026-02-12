<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class School extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'school_code',
        'npsn',
        'nama_sekolah',
        'kota',
        'provinsi',
        'alamat',
        'telepon',
        'email_kontak',
        'kepala_sekolah',
        'jenjang',
        'status',
        'catatan',
        'logo',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'school_id');
    }

    public function adminSekolah()
    {
        return $this->hasMany(User::class, 'school_id')->where('role', 'admin_sekolah');
    }

    public function guru()
    {
        return $this->hasMany(User::class, 'school_id')->where('role', 'guru');
    }

    public function siswa()
    {
        return $this->hasMany(User::class, 'school_id')->where('role', 'siswa');
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'school_id');
    }

    public function kvtScores()
    {
        return $this->hasMany(KvtScore::class, 'school_id');
    }

    public function license()
    {
        return $this->hasOne(KvtLicense::class, 'school_id')->latest();
    }

    public function licenses()
    {
        return $this->hasMany(KvtLicense::class, 'school_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'school_id');
    }

    public function emailAccounts()
    {
        return $this->hasMany(KvtEmailAccount::class, 'school_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Generate next school code like kvt.1, kvt.2, kvt.3...
     */
    public static function generateSchoolCode(): string
    {
        $lastSchool = self::withTrashed()->orderByRaw("CAST(SUBSTRING_INDEX(school_code, '.', -1) AS UNSIGNED) DESC")->first();

        if ($lastSchool) {
            $lastNumber = (int) str_replace('kvt.', '', $lastSchool->school_code);
            return 'kvt.' . ($lastNumber + 1);
        }

        return 'kvt.1';
    }

    public function hasActiveLicense(): bool
    {
        $license = $this->license;
        return $license && $license->status === 'aktif' && $license->berlaku_sampai >= now();
    }
}
