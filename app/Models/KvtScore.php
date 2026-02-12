<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KvtScore extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'class_id',
        'school_id',
        'kompetensi',
        'sub_kompetensi',
        'nilai',
        'predikat',
        'semester',
        'tahun_ajaran',
        'catatan',
        'dinilai_oleh',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'dinilai_oleh');
    }

    public static function hitungPredikat(float $nilai): string
    {
        return match (true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default => 'E',
        };
    }

    public function scopeBySemester($query, $semester, $tahunAjaran)
    {
        return $query->where('semester', $semester)->where('tahun_ajaran', $tahunAjaran);
    }
}
