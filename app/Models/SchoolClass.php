<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
    use SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'school_id',
        'nama_kelas',
        'jurusan',
        'tingkat',
        'tahun_ajaran',
        'semester',
        'wali_kelas_id',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_student', 'class_id', 'user_id');
    }

    public function kvtScores()
    {
        return $this->hasMany(KvtScore::class, 'class_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeBySchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }
}
