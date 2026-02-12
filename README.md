<p align="center">
  <img src="https://img.shields.io/badge/Universe-KVT-000000?style=for-the-badge&logo=laravel&logoColor=white" alt="Universe KVT">
  <br>
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/GSAP-3.12-88CE02?style=flat-square&logo=greensock&logoColor=white" alt="GSAP">
  <img src="https://img.shields.io/badge/License-Proprietary-red?style=flat-square" alt="License">
</p>

# Universe KVT — Platform Pendidikan Berbasis Kompetensi Vokasi Terpadu

> **Platform pusat pendidikan digital** untuk mengelola sekolah, guru, siswa, dan penilaian KVT (Kompetensi Vokasi Terpadu) dalam satu ekosistem terintegrasi dengan sistem email `@kvt.id` otomatis.

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Tech Stack](#-tech-stack)
- [Struktur Database](#-struktur-database)
- [Instalasi & Setup](#-instalasi--setup)
- [Akun Demo](#-akun-demo)
- [Struktur Folder](#-struktur-folder)
- [API Endpoints](#-api-endpoints)
- [Sistem Email @kvt.id](#-sistem-email-kvtid)
- [Sistem Lisensi](#-sistem-lisensi)
- [Role & Hak Akses](#-role--hak-akses)
- [Screenshots](#-screenshots)
- [Lisensi & Sponsor](#-lisensi--sponsor)
- [Kerja Sama](#-kerja-sama)
- [Kontak](#-kontak)

---

## 🎯 Tentang Proyek

**Universe KVT** adalah platform manajemen pendidikan berbasis web yang dirancang khusus untuk mengelola sekolah-sekolah vokasi di Indonesia. Setiap sekolah yang mendaftar akan otomatis mendapatkan:

- **School ID unik** (kvt.1, kvt.2, kvt.3, dst.)
- **Akun admin sekolah** dengan email resmi `@kvt.id`
- **Ruang data khusus** yang terisolasi per sekolah
- **Sistem penilaian KVT** dengan predikat otomatis (A–E)
- **Dashboard khusus** sesuai role masing-masing

Platform ini dirancang sebagai sistem multi-tenant di mana setiap sekolah beroperasi secara independen namun dikelola terpusat oleh Admin KVT.

---

## ✨ Fitur Utama

### 🏫 Manajemen Sekolah
- Pendaftaran sekolah otomatis via NPSN
- Approval/reject sekolah oleh Admin KVT
- Generate School Code otomatis (kvt.1, kvt.2, ...)
- Toggle status sekolah (aktif/nonaktif)

### 📧 Sistem Email @kvt.id
- Setiap user mendapat email KVT otomatis
- Format: `nama.user@kvt.1`, `nama.user@kvt.2`
- Siswa dengan NISN: `12345.nama@kvt.1`
- Admin: `admin.sekolah@kvt.1`
- Email digunakan sebagai login credential

### 👥 Manajemen User (CRUD Lengkap)
- Tambah/edit/hapus guru & siswa
- Email KVT otomatis saat registrasi
- Status: aktif, nonaktif, pending
- Pencarian & filter berdasarkan role

### 📚 Manajemen Kelas
- Buat kelas dengan jurusan, tingkat, tahun ajaran
- Assign wali kelas (guru)
- Daftarkan siswa ke kelas (many-to-many)
- Semester: Ganjil/Genap

### 📝 Penilaian KVT
- Input nilai per kompetensi vokasi
- Predikat otomatis: A (≥90), B (≥80), C (≥70), D (≥60), E (<60)
- Filter per semester & tahun ajaran
- Riwayat nilai lengkap per siswa

### 🔑 Sistem Lisensi
- 3 tier: **Basic**, **Pro**, **Premium**
- Kuota guru, siswa, kelas per tier
- Masa berlaku dengan auto-expire
- Upgrade/downgrade lisensi

### 📊 Dashboard Role-Based
- **Admin KVT**: Statistik global, approval sekolah, activity log
- **Admin Sekolah**: Info sekolah, statistik lokal, quick actions
- **Guru**: Kelas yang diajar, input nilai, riwayat penilaian
- **Siswa**: Profil, kelas, nilai KVT terbaru, rata-rata

### 🎨 UI/UX
- **Monochrome dark theme** (hitam-putih-abu)
- **GSAP ScrollTrigger** animations di landing page
- **Alpine.js** popups & interactive components
- **Responsive** design di semua perangkat
- **Elegant popup notifications** (success/error/warning/info)

---

## 🏗 Arsitektur Sistem

```
┌──────────────────────────────────────────────────────┐
│                    UNIVERSE KVT                      │
├──────────────────────────────────────────────────────┤
│                                                      │
│  ┌─────────┐  ┌──────────────┐  ┌─────────────────┐ │
│  │ Landing  │  │   Auth       │  │   Dashboard     │ │
│  │ Page     │  │ Login/Regis  │  │ (4 Role Views)  │ │
│  └─────────┘  └──────────────┘  └─────────────────┘ │
│                                                      │
│  ┌─────────────────────────────────────────────────┐ │
│  │              CRUD Modules                       │ │
│  │  Schools │ Users │ Classes │ Scores │ Licenses  │ │
│  └─────────────────────────────────────────────────┘ │
│                                                      │
│  ┌─────────────────────────────────────────────────┐ │
│  │           Middleware Layer                       │ │
│  │  Auth │ RoleMiddleware │ SchoolAccessMiddleware  │ │
│  └─────────────────────────────────────────────────┘ │
│                                                      │
│  ┌─────────────────────────────────────────────────┐ │
│  │             Data Layer                          │ │
│  │  Models │ Migrations │ Seeders │ Activity Log   │ │
│  └─────────────────────────────────────────────────┘ │
│                                                      │
│  ┌──────────┐  ┌───────────┐  ┌──────────────────┐  │
│  │  MySQL   │  │ REST API  │  │  Email @kvt.id   │  │
│  │  DB      │  │ (v1)      │  │  System          │  │
│  └──────────┘  └───────────┘  └──────────────────┘  │
└──────────────────────────────────────────────────────┘
```

---

## 🛠 Tech Stack

| Komponen | Teknologi | Versi |
|----------|-----------|-------|
| Backend | Laravel | 12.x |
| PHP | PHP | 8.2+ |
| Database | MySQL | 8.0 |
| Frontend CSS | Tailwind CSS | 3.x (CDN) |
| Interactivity | Alpine.js | 3.x (CDN) |
| Animations | GSAP + ScrollTrigger | 3.12.5 (CDN) |
| Font | Inter | Google Fonts |
| Local Dev | Laragon | 6.x |
| Template | Blade | Laravel Built-in |
| Auth | Laravel Auth | Session-based |

---

## 🗃 Struktur Database

### Tabel Utama

```
schools              users                classes
├── id (UUID)        ├── id               ├── id
├── school_code      ├── school_id (FK)   ├── school_id (FK)
├── npsn (unique)    ├── nama             ├── nama_kelas
├── nama_sekolah     ├── email            ├── jurusan
├── kota             ├── kvt_email        ├── tingkat
├── provinsi         ├── password         ├── tahun_ajaran
├── jenjang          ├── role (enum)      ├── semester (enum)
├── status (enum)    ├── status (enum)    ├── wali_kelas_id (FK)
└── timestamps       ├── nisn/nip         └── timestamps
                     └── timestamps

kvt_scores           kvt_licenses         kvt_email_accounts
├── id               ├── id               ├── id
├── student_id (FK)  ├── school_id (FK)   ├── user_id (FK)
├── class_id (FK)    ├── tipe_lisensi     ├── school_id (FK)
├── school_id (FK)   ├── berlaku_mulai    ├── kvt_email (unique)
├── kompetensi       ├── berlaku_sampai   ├── display_name
├── nilai (decimal)  ├── max_guru/siswa   └── timestamps
├── predikat         ├── max_kelas
├── semester         └── timestamps       activity_logs
├── tahun_ajaran                          ├── id
├── dinilai_oleh(FK)                      ├── user_id (FK)
└── timestamps                            ├── action
                                          ├── description
class_student (pivot)                     ├── model_type/id
├── class_id (FK)                         ├── old_data (JSON)
├── user_id (FK)                          ├── new_data (JSON)
└── timestamps                            └── timestamps
```

### Relasi

- `School` → hasMany → `User`, `SchoolClass`, `KvtScore`, `KvtLicense`, `KvtEmailAccount`
- `User` → belongsTo → `School`
- `User` → belongsToMany → `SchoolClass` (pivot: class_student)
- `SchoolClass` → hasMany → `KvtScore`
- `KvtScore` → belongsTo → `User` (student & penilai)

---

## 🚀 Instalasi & Setup

### Prasyarat

- PHP 8.2+
- Composer 2.x
- MySQL 8.0+
- Laragon / XAMPP / Docker
- Git

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/kuro-myths/kvt-pendidikan.git
cd kvt-pendidikan

# 2. Install dependencies
composer install --optimize-autoloader

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database (.env)
# DB_CONNECTION=mysql
# DB_DATABASE=universe_kvt
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Buat database
mysql -u root -e "CREATE DATABASE universe_kvt;"

# 6. Jalankan migrasi & seeder
php artisan migrate:fresh --seed

# 7. Jalankan server
php artisan serve
```

Akses: `http://localhost:8000`

---

## 🔐 Akun Demo

Setelah menjalankan seeder, akun-akun berikut siap digunakan:

| Role | Email KVT | Password | Akses |
|------|-----------|----------|-------|
| **Admin KVT** | `universe.kvt@kvt.id` | `admin12345` | Kelola semua sekolah, lisensi, approval |
| **Admin Sekolah** | `admin.smkn1@kvt.1` | `sekolah123` | Kelola user, kelas, nilai di sekolahnya |
| **Guru** | `budi.santoso@kvt.1` | `guru12345` | Input nilai, lihat kelas yang diajar |
| **Siswa** | `rizki.pratama@kvt.1` | `siswa12345` | Lihat nilai & kelas |

Sekolah pending (untuk testing approval): **SMK Negeri 3 Bandung** (`kvt.2`)

---

## 📁 Struktur Folder

```
kvt-pendidikan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login, register sekolah, logout
│   │   │   ├── DashboardController.php     # 4 dashboard views
│   │   │   ├── SchoolController.php        # CRUD sekolah + approve/reject
│   │   │   ├── UserController.php          # CRUD user + auto KVT email
│   │   │   ├── ClassController.php         # CRUD kelas + assign siswa
│   │   │   ├── KvtScoreController.php      # CRUD nilai + auto predikat
│   │   │   └── LicenseController.php       # CRUD lisensi sekolah
│   │   └── Middleware/
│   │       ├── RoleMiddleware.php           # Cek role & status aktif
│   │       └── SchoolAccessMiddleware.php   # Cek akses sekolah
│   └── Models/
│       ├── User.php                        # + generateKvtEmail()
│       ├── School.php                      # + generateSchoolCode()
│       ├── SchoolClass.php                 # table: classes
│       ├── KvtScore.php                    # + hitungPredikat()
│       ├── KvtLicense.php                  # + getLimits(), isActive()
│       ├── KvtEmailAccount.php
│       └── ActivityLog.php                 # + log() static method
├── database/
│   ├── migrations/                         # 9 migration files
│   └── seeders/
│       └── DatabaseSeeder.php              # Full sample data
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                   # Public layout (GSAP, Alpine)
│   │   └── dashboard.blade.php             # Dashboard layout (sidebar)
│   ├── landing.blade.php                   # Landing page + animations
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register-school.blade.php
│   ├── dashboard/
│   │   ├── admin-kvt.blade.php
│   │   ├── admin-sekolah.blade.php
│   │   ├── guru.blade.php
│   │   └── siswa.blade.php
│   ├── schools/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── users/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── classes/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── scores/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── licenses/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
├── routes/
│   ├── web.php                             # All web routes
│   └── api.php                             # REST API v1
└── .env                                    # Environment config
```

---

## 🌐 API Endpoints

```
GET  /api/v1/school/{code}           → Info sekolah by school_code
GET  /api/v1/school/{code}/students  → Daftar siswa sekolah
GET  /api/v1/school/{code}/scores    → Daftar nilai KVT sekolah
```

API ini menggunakan School Code (kvt.1, kvt.2) sebagai identifier untuk integrasi dengan LMS atau sistem eksternal.

---

## 📧 Sistem Email @kvt.id

Setiap user yang terdaftar di Universe KVT mendapat email unik berdasarkan kode sekolah:

| Role | Format | Contoh |
|------|--------|--------|
| Admin KVT | `universe.kvt@kvt.id` | `universe.kvt@kvt.id` |
| Admin Sekolah | `nama.admin@kvt.{N}` | `admin.smkn1@kvt.1` |
| Guru | `nama.lengkap@kvt.{N}` | `budi.santoso@kvt.1` |
| Siswa | `nisn.nama@kvt.{N}` | `12345.rizki.pratama@kvt.1` |
| Siswa (tanpa NISN) | `nama.lengkap@kvt.{N}` | `dewi.lestari@kvt.2` |

Email KVT berfungsi sebagai:
- Login credential utama
- Identitas resmi dalam platform
- Tercatat di tabel `kvt_email_accounts`

---

## 🔑 Sistem Lisensi

| Fitur | Basic | Pro | Premium |
|-------|-------|-----|---------|
| Maks. Guru | 10 | 50 | 200 |
| Maks. Siswa | 100 | 500 | 2.000 |
| Maks. Kelas | 5 | 20 | 100 |
| Email @kvt.id | ✅ | ✅ | ✅ |
| Penilaian KVT | ✅ | ✅ | ✅ |
| Dashboard | ✅ | ✅ | ✅ |
| API Akses | ❌ | ✅ | ✅ |
| Prioritas Support | ❌ | ✅ | ✅ |

Lisensi Basic otomatis diberikan saat sekolah disetujui. Upgrade via Admin KVT.

---

## 👤 Role & Hak Akses

| Aksi | Admin KVT | Admin Sekolah | Guru | Siswa |
|------|-----------|---------------|------|-------|
| Kelola semua sekolah | ✅ | ❌ | ❌ | ❌ |
| Approve/reject sekolah | ✅ | ❌ | ❌ | ❌ |
| CRUD lisensi | ✅ | View only | ❌ | ❌ |
| CRUD user (guru/siswa) | ✅ | ✅ (own school) | ❌ | ❌ |
| CRUD kelas | ✅ | ✅ (own school) | ❌ | ❌ |
| Input nilai KVT | ✅ | ✅ | ✅ | ❌ |
| Lihat nilai | ✅ | ✅ | ✅ (own) | ✅ (own) |
| Dashboard | ✅ | ✅ | ✅ | ✅ |

---

## 📸 Screenshots

### Landing Page
> Monochrome dark theme dengan animasi GSAP ScrollTrigger — hero, features grid, 3-step how-it-works, email showcase, pricing cards, CTA.

### Dashboard Admin KVT
> Statistik global, pending schools approval, recent activity log.

### Dashboard Siswa
> Profil, daftar kelas, nilai KVT terbaru, rata-rata nilai.

---

## 📄 Lisensi & Sponsor

Proyek ini dilisensikan di bawah **Lisensi Hak Cipta Terbatas** — lihat file [LICENSE](LICENSE) untuk detail lengkap.

### Sponsor

Proyek ini dikembangkan dengan dukungan sponsor. Jika Anda atau organisasi Anda ingin menjadi sponsor resmi Universe KVT:

- **Gold Sponsor** — Logo di landing page, README, dan dashboard
- **Silver Sponsor** — Logo di README dan footer
- **Bronze Sponsor** — Nama di halaman sponsor

Hubungi: [kuro-myths](https://github.com/kuro-myths)

---

## 🤝 Kerja Sama

Universe KVT terbuka untuk kerja sama dalam bentuk:

1. **Integrasi LMS** — Koneksi API dengan learning management system yang sudah ada
2. **Custom Deployment** — Setup mandiri untuk dinas pendidikan daerah
3. **White Label** — Branding khusus untuk institusi pendidikan
4. **Pengembangan Fitur** — Fitur tambahan sesuai kebutuhan mitra
5. **Pelatihan** — Workshop penggunaan platform untuk sekolah

### Syarat Kerja Sama

- Kerja sama resmi memerlukan **MoU** yang ditandatangani kedua pihak
- Mitra wajib menjaga **kerahasiaan data** siswa dan guru
- Penggunaan untuk **tujuan pendidikan** saja
- Mencantumkan **kredit** ke Universe KVT di produk turunan
- Biaya kerja sama disesuaikan dengan **skala implementasi**

### Atas Nama

Kerja sama dan lisensi sponsor dikeluarkan atas nama:

> **Universe KVT — Platform Pendidikan Digital**  
> Dikembangkan oleh [kuro-myths](https://github.com/kuro-myths)  
> Repository: [github.com/kuro-myths/kvt-pendidikan](https://github.com/kuro-myths/kvt-pendidikan)

---

## 🛡️ Keamanan

- Password di-hash menggunakan bcrypt (Laravel default)
- Session-based authentication
- CSRF protection pada semua form
- Role-based middleware untuk setiap route
- School-scoped access — user hanya bisa akses data sekolahnya
- Soft deletes untuk data recovery
- Activity log untuk audit trail

---

## 📞 Kontak

- **GitHub**: [@kuro-myths](https://github.com/kuro-myths)
- **Repository**: [kvt-pendidikan](https://github.com/kuro-myths/kvt-pendidikan)

---

<p align="center">
  <strong>Universe KVT</strong> © 2026 — Platform Pendidikan Resmi Berbasis KVT
  <br>
  Built with ❤️ using Laravel 12
</p>
