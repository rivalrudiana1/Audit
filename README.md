# Sistem Audit TPU (Tempat Pemakaman Umum)

## 1. Tajuk Projek & Ringkasan
**Sistem Audit TPU**
Aplikasi web ini dibangunkan untuk mengurus dan memantau audit Tempat Pemakaman Umum (TPU). Ia memudahkan proses penjanaan laporan audit, membolehkan pengurusan profil dan tahap pengguna (Admin/Kepala TPU), serta menyediakan platform berpusat untuk muat naik dokumen dan penjejakan maklumat TPU.

## 2. Teknologi yang Digunakan (Tech Stack)
- **Frontend**: Laravel Blade, Tailwind CSS, Alpine.js, Vite
- **Backend**: PHP 8.3+, Laravel (v11/v13-dev), Maatwebsite Excel (untuk eksport Excel)
- **Pangkalan Data**: SQLite (default) / MySQL / PostgreSQL (boleh dikonfigurasi melalui `.env`)
- **Perkakas/Infrastruktur**: Composer, NPM, Git

## 3. Ciri-Ciri Utama & Logik Perniagaan
- **Autentikasi Pengguna**: Log masuk selamat dengan perlindungan laluan berasaskan middleware (`auth`).
- **Papan Pemuka (Dashboard)**: Antaramuka utama yang memaparkan ringkasan data audit.
- **Pengurusan Audit**: Fungsi untuk menjana (`/audit/generate`) dan menyemak data audit.
- **Pengurusan Fail/Muat Naik**: Modul khusus untuk memuat naik dokumen (`/upload`).
- **Kawalan Akses Berasaskan Peranan (RBAC)**: Pemisahan fungsi antara `Admin` (mengurus pengguna dan data TPU penuh) dan `Kepala TPU`.
- **Pengurusan Data Teras (CRUD)**: Pengurusan pengguna (`/users`) dan maklumat TPU (`/tpus`).

## 4. Struktur Direktori Projek
- `app/`: Mengandungi logik utama aplikasi seperti Model, Controller (Cth: `AuditController`, `TpuController`), dan Middleware.
- `routes/`: Menyimpan definisi laluan API dan Web (`web.php`).
- `resources/`: Menyimpan fail paparan antaramuka (Blade template) serta aset belum diproses (CSS/JS).
- `database/`: Fail migrasi pangkalan data, seeder, dan factory.
- `public/`: Aset awam yang telah siap diproses (CSS, JS, Imej) dan fail `index.php` (titik mula aplikasi).

## 5. Panduan Pemasangan & Cara Menjalankan Projek
Berikut adalah langkah-langkah untuk menjalankan projek ini di komputer tempatan:

1. **Pasang Dependensi Backend & Frontend**:
   ```bash
   composer install
   npm install
   ```
2. **Tetapan Persekitaran (Environment)**:
   Salin fail contoh persekitaran dan sesuaikan tetapan pangkalan data:
   ```bash
   cp .env.example .env
   ```
3. **Jana Kunci Aplikasi & Pangkalan Data**:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
4. **Jalankan Pelayan Pembangunan**:
   Jalankan arahan berikut (sebaiknya dalam terminal berasingan) untuk memulakan persekitaran pembangunan:
   ```bash
   npm run dev
   php artisan serve
   ```

## 6. Endpoint API / Skema Pangkalan Data
Laluan utama (Routes) yang tersedia dalam sistem:
- **Umum (Log masuk diperlukan)**:
  - `GET /dashboard` : Papan pemuka pengguna
  - `GET /audit`, `POST /audit/generate` : Pengurusan audit
  - `GET /profile`, `PATCH /profile`, `DELETE /profile` : Pengurusan profil pengguna
  - `GET /upload`, `POST /upload` : Pengurusan muat naik (Akses: Admin & Kepala TPU)
- **Admin Sahaja**:
  - `Resource /users` : CRUD Pengguna
  - `Resource /tpus` : CRUD TPU
