# Sistem Audit TPU (Tempat Pemakaman Umum)

## 1. Judul Proyek & Ringkasan
**Sistem Audit TPU**
Aplikasi web ini dibangun untuk mengelola dan memantau audit Tempat Pemakaman Umum (TPU). Sistem ini mempermudah proses pembuatan laporan audit, memungkinkan manajemen profil dan peran pengguna (Admin/Kepala TPU), serta menyediakan platform terpusat untuk unggah dokumen dan pelacakan informasi TPU.

## 2. Teknologi yang Digunakan (Tech Stack)
- **Frontend**: Laravel Blade, Tailwind CSS, Alpine.js, Vite
- **Backend**: PHP 8.3+, Laravel (v11/v13-dev), Maatwebsite Excel (untuk *export* Excel)
- **Database**: SQLite (*default*) / MySQL / PostgreSQL (dapat dikonfigurasi melalui `.env`)
- **Perkakas/Infrastruktur**: Composer, NPM, Git

## 3. Fitur Utama & Logika Bisnis
- **Authentication Pengguna**: Login aman dengan proteksi *routes* berbasis middleware (`auth`).
- **Dashboard**: Antarmuka utama yang menampilkan ringkasan data audit.
- **Manajemen Audit**: Fungsi untuk membuat (*generate*) di `/audit/generate` dan meninjau data audit.
- **Manajemen File/Unggah**: Modul khusus untuk mengunggah dokumen (`/upload`).
- **Kontrol Akses Berbasis Peran (RBAC)**: Pemisahan fungsi antara `Admin` (mengelola pengguna dan data TPU penuh) dan `Kepala TPU`.
- **Manajemen Data Inti (CRUD)**: Pengelolaan pengguna (`/users`) dan informasi TPU (`/tpus`).

## 4. Struktur Direktori Proyek
- `app/`: Berisi logika utama aplikasi seperti Model, Controller (Contoh: `AuditController`, `TpuController`), dan Middleware.
- `routes/`: Menyimpan definisi *routes* API dan Web (`web.php`).
- `resources/`: Menyimpan file tampilan antarmuka (Blade template) serta aset mentah (CSS/JS).
- `database/`: File migration database, seeder, dan factory.
- `public/`: Aset publik yang telah melalui proses *build* (CSS, JS, Gambar) dan file `index.php` (titik masuk aplikasi).

## 5. Panduan Instalasi & Cara Menjalankan Proyek
Berikut adalah langkah-langkah untuk melakukan *deploy* atau menjalankan proyek ini di komputer lokal:

1. **Instal *Dependencies* Backend & Frontend**:
   ```bash
   composer install
   npm install
   ```
2. **Konfigurasi Environment**:
   Salin file contoh *environment* dan sesuaikan pengaturan database:
   ```bash
   cp .env.example .env
   ```
3. **Generate Kunci Aplikasi & Database**:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
4. **Jalankan Server Development**:
   Jalankan perintah berikut (sebaiknya di terminal terpisah) untuk memulai lingkungan *development*:
   ```bash
   npm run dev
   php artisan serve
   ```

## 6. Endpoint API / Skema Database
Daftar *routes* utama yang tersedia dalam sistem:
- **Umum (Membutuhkan Login)**:
  - `GET /dashboard` : Dashboard pengguna
  - `GET /audit`, `POST /audit/generate` : Manajemen audit
  - `GET /profile`, `PATCH /profile`, `DELETE /profile` : Manajemen profil pengguna
  - `GET /upload`, `POST /upload` : Manajemen unggahan (Akses: Admin & Kepala TPU)
- **Khusus Admin**:
  - `Resource /users` : CRUD Pengguna
  - `Resource /tpus` : CRUD TPU
