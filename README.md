<p align="center">
  <img src="public/assets/img/logo-turningcode.png" width="320" alt="TurningCode Logo">
</p>

<h1 align="center">🚀 TurningCode</h1>

<p align="center">
  <b>Elevate your coding journey from zero to hero with a modern, fast, and interactive learning platform.</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/phpMyAdmin-5.2+-F8981D?style=flat-square&logo=phpmyadmin&logoColor=white" alt="phpMyAdmin">
</p>

---

## 📖 Vision & Philosophy

**TurningCode** bukan sekadar materi belajar di layar. Nama ini membawa filosofi **"The Turning Point"** — sebuah momen krusial di mana kebingungan berubah menjadi pemahaman, dan kode yang Anda tulis mulai "hidup". Kami membangun platform ini untuk menjadi jembatan bagi para pemula agar tidak terjebak dalam *tutorial hell*, melainkan bergerak maju melalui kurikulum yang terstruktur dan sistem manajemen belajar yang cerdas.

Platform ini mengusung estetika **Modern & Premium**, menggabungkan kecepatan navigasi **Single Page Application (SPA)** dengan keandalan backend Laravel. Setiap interaksi dirancang untuk memberikan *feedback* instan, meminimalkan hambatan teknis agar fokus Anda tetap pada satu hal: **Mempelajari Kode.**

---

## ✨ Highlight Fitur Unggulan

### 🌗 Seamless SPA Experience
Berbeda dengan web konvensional, TurningCode menggunakan arsitektur **Blade Fragments SPA**. Hal ini memungkinkan Anda berpindah halaman — dari membaca materi ke mengatur jadwal — tanpa merasakan jeda pemuatan halaman (*full page reload*). Transisinya halus, cepat, dan menghemat data.

### 🛡️ Authentication Level: Secure & Simple
Akses platform dilindungi oleh sistem **Email OTP (One-Time Password)**. Tidak ada lagi kerumitan menghafal password panjang yang sulit. Cek Gmail Anda, masukkan kodenya, dan Anda langsung berada di dalam lingkungan belajar yang aman.

### 🔔 Smart Notification System (Admin ONLY)
Admin dilengkapi dengan **Dashboard Control Tower**. Melalui ikon lonceng dinamis di header, Admin akan mendapatkan notifikasi real-time jika ada laporan masalah dari pengguna atau aktivitas kritis lainnya. Badge merah yang menyala memastikan tidak ada isu yang terlewatkan.

### 🚩 Interactive Issue Tracking
Sistem pelaporan masalah yang terintegrasi memungkinkan pengguna melaporkan bug atau kebingungan materi secara instan. Admin dapat mengelola laporan ini langsung dari Dashboard menggunakan fitur **Accept/Resolve** — mempercepat sirkulasi perbaikan demi pengalaman belajar yang lebih baik.

### ⌨️ Integrated Web Terminal (CMD)
Untuk kebutuhan pengelolaan tingkat lanjut, Admin memiliki akses ke **Web Terminal Overlay**. Jalankan perintah sistem, cek status server, atau lakukan tugas administratif langsung di browser tanpa perlu membuka SSH Client eksternal.

---

## 🛠️ Tech Stack & Architecture

### Backend Powerhouse
- **Laravel 13**: Framework PHP paling modern untuk skalabilitas dan keamanan tinggi.
- **MySQL & phpMyAdmin**: Sistem manajemen database relasional yang andal untuk skalabilitas data besar.
- **Queued Mail Services**: Pengiriman OTP dan verifikasi dilakukan di latar belakang (*background process*) menggunakan Worker, sehingga aplikasi tetap responsif.

### Frontend Aesthetics
- **Vite + Tailwind CSS 4** — Pemanfaatan utility-first CSS terbaru untuk desain premium dan performa aset yang optimal.
- **MySQL & phpMyAdmin** — Sistem manajemen database relasional yang andal untuk skalabilitas data besar.gan milidetik.
- **Vanilla JavaScript SPA Engine**: Logika navigasi kustom yang ringan tanpa overhead framework JS berat seperti React atau Vue di sisi Admin.

---

## 📁 Project Structure

```
TurningCode/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Controllers: Chat, Materi, SubMateri
│   │   │   ├── AdminController.php # Admin SPA & Routing logic
│   │   │   ├── AuthController.php  # Authentication & OTP logic
│   │   │   └── UserController.php  # User SPA & Dashboard logic
│   │   └── Middleware/
│   │       └── EnsureRole.php      # Role-based protection
│   ├── Models/                     # User, Materi, SubMateri, Schedule, IssueReport, dll.
│   └── Providers/
├── config/
├── database/
│   ├── migrations/                 # Database Schema
│   └── database.sqlite             # Lightweight portable DB
├── resources/
│   ├── js/                         # SPA_admin.js & SPA_user.js
│   └── views/
│       ├── spa/
│       │   └── fragments/          # SPA UI components (blade fragments)
│       └── layouts/                # Main SPA layouts
├── routes/
│   └── web.php                     # Unified web & API routes
├── composer.json
├── package.json
└── vite.config.js
```

---

## 🚀 Quick Start Guide

### 1. Prasyarat Sistem
- **PHP**: >= 8.3
- **Database**: SQLite (built-in support di Laravel)
- **Node.js**: >= 18.x
- **Composer**: Dependency manager untuk PHP

### 2. Panduan Instalasi Lengkap

Ikuti langkah-langkah di bawah ini untuk menyiapkan lingkungan pengembangan Anda:

#### Step 1: Clone Repository
Clone project ini ke direktori lokal Anda:
```bash
git clone https://github.com/Hackivers/TurningCode.git
cd TurningCode
```

#### Step 2: Install Dependencies
Pastikan Anda sudah menginstal Composer dan Node.js, lalu jalankan:
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

#### Step 3: Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan buat App Key:
```bash
cp .env.example .env
php artisan key:generate
```
> [!IMPORTANT]
> Buka file `.env` dan konfigurasi bagian **MAIL_HOST**, **MAIL_USERNAME**, dan **MAIL_PASSWORD**. Fitur login TurningCode menggunakan OTP via email, sehingga SMTP yang valid (seperti Gmail) sangat diperlukan.

#### Step 4: Setup Database (MySQL)
TurningCode menggunakan MySQL sebagai database utama. 
1. Buka **phpMyAdmin** Anda.
2. Buat database baru dengan nama `turningcode`.
3. Pastikan konfigurasi di file `.env` sudah sesuai (DB_HOST, DB_USERNAME, DB_PASSWORD).

#### Step 5: Migrasi & Seeding
Jalankan migrasi untuk membuat struktur tabel dan mengisi data awal (Materi, Admin, dll):
```bash
php artisan migrate --seed
```

#### Step 6: Build Assets
Kompilasi aset CSS dan JavaScript menggunakan Vite:
```bash
npm run build
```

---

### 3. Cara Menjalankan Aplikasi

Anda dapat menjalankan server pengembangan dengan perintah terpadu atau secara terpisah:

**A. Perintah Terpadu (Direkomendasikan):**
Menjalankan Web Server, Vite, dan Queue Worker sekaligus dalam satu terminal:
```bash
composer dev
```

**B. Perintah Terpisah:**
Jika ingin memantau log satu per satu, jalankan di terminal berbeda:
1. `php artisan serve` — Menjalankan Web Server di port 8000.
2. `npm run dev` — Menjalankan Vite untuk hot-reloading aset.
3. `php artisan queue:work` — Menjalankan Worker untuk pemrosesan Email OTP.

---

### 🔐 Akun Akses Default
Setelah berhasil melakukan `migrate --seed`, Anda dapat mencoba masuk dengan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@example.com` | `password` |
| **User** | `user@example.com` | `password` |

---

## ⚙️ Environment Configuration

| Key | Description |
|-----|-------------|
| `APP_URL` | Domain atau URL akses aplikasi (default: http://localhost:8000) |
| `MAIL_HOST` | Host SMTP untuk pengiriman OTP (Rekomendasi: smtp.gmail.com) |
| `MAIL_PASSWORD` | App Password dari Google Account (Jangan gunakan password asli email!) |
| `SESSION_DRIVER` | Mengatur masa aktif sesi login pengguna (default: file) |

---

## 🗺️ Future Roadmap

- [ ] **Quiz Integration**: Uji pemahaman materi dengan Passing Threshold 80%.
- [ ] **Gamification System**: Dapatkan EXP dan Rank (Pemula -> Legend) setiap kali menyelesaikan sub-materi.
- [ ] **Dark Mode Toggle**: Dukungan penuh tema gelap untuk kenyamanan mata saat belajar di malam hari.
- [ ] **Mobile App Wrapper**: Transformasi SPA menjadi aplikasi mobile menggunakan Capacitor.

---

## 👥 Contributors

<p align="center">
  <a href="https://github.com/Hackivers/TurningCode"><img src="https://img.shields.io/badge/-hanzz-7c3aed?style=for-the-badge&logo=github&logoColor=white" alt="hanzz"></a>
  <a href="https://github.com/Hackivers/TurningCode"><img src="https://img.shields.io/badge/-Jester-7c3aed?style=for-the-badge&logo=github&logoColor=white" alt="Jester"></a>
  <a href="https://github.com/Hackivers/TurningCode"><img src="https://img.shields.io/badge/-ghostface-7c3aed?style=for-the-badge&logo=github&logoColor=white" alt="ghostface"></a>
  <a href="https://github.com/Hackivers/TurningCode"><img src="https://img.shields.io/badge/-Mychel09-7c3aed?style=for-the-badge&logo=github&logoColor=white" alt="Mychel09"></a>
  <a href="https://github.com/Hackivers/TurningCode"><img src="https://img.shields.io/badge/-maousama-7c3aed?style=for-the-badge&logo=github&logoColor=white" alt="maousama"></a>
</p>

---

## 📄 License & Contribution

Project ini bersifat **Open Source** di bawah lisensi [MIT](https://opensource.org/licenses/MIT). Kami sangat menghargai kontribusi dari komunitas, baik berupa *bug reporting*, saran desain, maupun penambahan materi pembelajaran.

<p align="center">
  <b>Crafted with passion by the TurningCode Dev Team.</b>
</p>
