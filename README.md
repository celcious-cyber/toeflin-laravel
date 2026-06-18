# TOEFLin - CBT TOEFL Simulation App

![TOEFLin Logo](public/favicon.svg)

TOEFLin adalah sebuah aplikasi web Computer-Based Test (CBT) interaktif untuk simulasi ujian TOEFL. Dibangun menggunakan **Laravel**, **Tailwind CSS**, dan **Alpine.js**, aplikasi ini menyajikan pengalaman ujian yang nyata lengkap dengan pengatur waktu, pemutar audio per bagian ujian, manajemen soal yang terstruktur, hingga konversi skor otomatis dan sertifikat.

---

## 🎯 Fitur Utama

### 🧑‍🎓 Portal Mahasiswa (Student)
- **Simulasi Ujian Real-time**: Pengalaman *Computer-Based Test* yang dirancang semirip mungkin dengan ujian TOEFL asli.
- **Dukungan Audio & Teks Bacaan (Passage)**: 
  - Bagian *Listening* dilengkapi pemutar audio cerdas.
  - Bagian *Reading* menampilkan teks bacaan yang tetap berada di layar sementara soal dapat di-*scroll* secara independen.
- **Kuota Ujian Mingguan**: Mahasiswa hanya dapat mengerjakan satu simulasi ujian setiap 7 hari, mendorong jadwal belajar yang teratur.
- **Pengajuan Tambahan Kuota (Request)**: Jika batas mingguan tercapai, mahasiswa dapat mengajukan permohonan kuota ujian tambahan kepada Admin.
- **Penilaian Otomatis (Auto Scoring)**: Menghitung jawaban benar dan otomatis mengonversinya ke skor TOEFL terstandar.
- **Riwayat Ujian & Sertifikat PDF**: Mahasiswa dapat melihat riwayat ujian sebelumnya dan mengunduh sertifikat digital hasil ujian dalam format PDF.

### 🛡️ Portal Pengelola (Admin & Super Admin)
- **Dashboard Analitik**: Pantauan *real-time* jumlah mahasiswa, bank soal, ujian aktif, dan permohonan kuota masuk.
- **Manajemen Bank Soal**: Mengelola soal berbasis bagian (*Listening*, *Structure*, *Reading*), lengkap dengan opsi audio dan paragraf teks bacaan (*Passage*).
- **Manajemen Paket Ujian**: Menggabungkan berbagai instruksi dan butir soal ke dalam paket-paket ujian siap pakai.
- **Manajemen Mahasiswa**: Melihat riwayat lengkap ujian tiap mahasiswa beserta biodatanya.
- **Persetujuan Kuota (Approval)**: Mengelola permohonan kuota ujian mahasiswa dengan sekali klik (Setujui / Tolak).
- **Manajemen Akun (Khusus Super Admin)**: Super Admin memiliki hak istimewa untuk mengelola profil dan menambahkan akun Admin atau Super Admin baru.

---

## 🛠️ Tech Stack
- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Templating, Tailwind CSS, Alpine.js
- **Database**: SQLite (dapat dikonfigurasi ke MySQL/PostgreSQL)

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal Anda:

### 1. Prasyarat Sistem
Pastikan Anda sudah menginstal perangkat lunak berikut:
- **PHP** (minimal versi 8.2)
- **Composer** (untuk dependensi PHP)
- **Node.js & npm** (untuk *compiling* Tailwind CSS)

### 2. Langkah Instalasi

1. **Clone Repositori**
   ```bash
   git clone https://github.com/celcious-cyber/toeflin-laravel.git
   cd toeflin-laravel
   ```

2. **Instal Dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file konfigurasi bawaan dan *generate* kunci aplikasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Siapkan Database (Migrasi & Seeding)**
   Jalankan perintah ini untuk membuat struktur tabel dan mengisi data awal (seperti akun bawaan dan konversi skor):
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   Anda membutuhkan dua terminal yang berjalan secara bersamaan:
   
   **Terminal 1 (Backend - Laravel Server):**
   ```bash
   php artisan serve
   ```
   
   **Terminal 2 (Frontend - Tailwind Vite):**
   ```bash
   npm run dev
   ```

   Aplikasi kini dapat diakses melalui browser Anda di `http://127.0.0.1:8000`.

---

## 🔐 Akun Default (Hasil Seeding)

Gunakan akun berikut untuk masuk setelah Anda melakukan *seeding* database:

| Peran (Role) | Email | Kata Sandi (Password) |
| :--- | :--- | :--- |
| **Super Admin** | `admin@admin.com` | `admin123` |
| **Mahasiswa** | `student@student.com` | `student123` |

*(Akses portal admin berada di `http://127.0.0.1:8000/admin/login`)*

---

## 🤝 Kontribusi & Pengembangan

Proyek ini dibangun oleh **Celcious Cyber** dengan bantuan *AI Agent*. Silakan melakukan *fork*, menambahkan fitur, dan mengirimkan *Pull Request* jika Anda memiliki ide pengembangan yang menarik!
