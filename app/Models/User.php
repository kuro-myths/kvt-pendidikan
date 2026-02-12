<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'school_id',
        'nama',
        'name',
        'email',
        'kvt_email',
        'nisn',
        'nip',
        'role',
        'status',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_student', 'user_id', 'class_id');
    }

    public function taughtClasses()
    {
        return $this->hasMany(SchoolClass::class, 'wali_kelas_id');
    }

    public function kvtScores()
    {
        return $this->hasMany(KvtScore::class, 'student_id');
    }

    public function scoredBy()
    {
        return $this->hasMany(KvtScore::class, 'dinilai_oleh');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function kvtEmailAccount()
    {
        return $this->hasOne(KvtEmailAccount::class);
    }

    public function kvtEmailAccounts()
    {
        return $this->hasMany(KvtEmailAccount::class);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeBySchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function isAdminKvt(): bool
    {
        return $this->role === 'admin_kvt';
    }
    public function isAdminSekolah(): bool
    {
        return $this->role === 'admin_sekolah';
    }
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function getDisplayEmail(): string
    {
        return $this->kvt_email ?? $this->email;
    }

    public static function generateKvtEmail(string $nama, string $schoolCode, string $role = 'siswa', ?string $nisn = null): string
    {
        $cleanName = strtolower(str_replace(' ', '.', trim($nama)));
        $cleanName = preg_replace('/[^a-z0-9.]/', '', $cleanName);
        if ($role === 'siswa' && $nisn) {
            return "{$nisn}.{$cleanName}@{$schoolCode}";
        }
        return "{$cleanName}@{$schoolCode}";
    }
}
