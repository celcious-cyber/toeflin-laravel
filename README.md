<p align="center">
  <img src="public/toeflin.svg" alt="TOEFLin Logo" width="300">
</p>

<h1 align="center">TOEFLin - CBT TOEFL Simulation Platform</h1>

<p align="center">
  <strong>Platform Simulasi Ujian TOEFL Berbasis Komputer (Computer-Based Test) Interaktif dan Real-time.</strong><br>
  Dirancang khusus untuk memberikan pengalaman ujian yang realistis, aman, dan mudah dikelola oleh instansi/universitas.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

---

## ✨ Fitur Utama (Features)

Aplikasi TOEFLin dibagi menjadi dua antarmuka utama: **Portal Mahasiswa** (Peserta Ujian) dan **Portal Pengelola** (Admin/Super Admin).

### 🎓 Portal Mahasiswa (Student Panel)
- **Real-Time CBT Simulation**: Antarmuka ujian yang didesain semirip mungkin dengan format ujian TOEFL ITP/iBT asli.
- **Audio & Reading Synchronized**:
  - Dukungan pemutar audio bawaan khusus untuk sesi *Listening Comprehension*.
  - Tampilan layar *split-view* (bersebelahan) untuk membaca teks (*Passage*) di sisi kiri, dan menjawab soal di sisi kanan pada sesi *Reading Comprehension*.
- **Auto-Scoring & Conversion**: Skor mentah (*raw score*) langsung dikonversi ke skor TOEFL terstandar secara otomatis di akhir ujian.
- **Sertifikat Digital (PDF)**: Mahasiswa dapat mengunduh dan mencetak sertifikat hasil skor ujian mereka seketika.
- **Sistem Kuota Ujian (7-Day Cooldown)**: Membatasi percobaan ujian per mahasiswa sebanyak 1 kali dalam seminggu untuk menghindari *spam*.
- **Permohonan Ujian Ulang (Request Attempt)**: Jika mahasiswa butuh ujian lebih cepat, mereka bisa mengirim "Permohonan" kepada Admin melalui *dashboard*.

### 🛡️ Portal Pengelola (Admin Panel)
- **Dashboard Analitik**: Ringkasan jumlah pengguna, butir soal di bank data, ujian yang sedang berjalan, hingga permohonan kuota yang tertunda.
- **Manajemen Bank Soal Lengkap**:
  - Modul pembuatan soal untuk *Listening, Structure*, dan *Reading*.
  - Fitur unggah fail Audio.
  - Fitur pembuatan Wacana Teks (*Passages*) mandiri.
- **Paket Ujian (*Test Packages*)**: Kumpulan/bundel dari instruksi dan soal-soal terpilih beserta durasi waktu tiap sesinya yang bisa dipublikasikan (*Publish*).
- **Manajemen Pengguna (User Management)**: 
  - Melihat hasil skor, riwayat ujian, dan detail akun mahasiswa.
  - Persetujuan (Approval) permohonan kuota ujian tambahan dengan sekali klik.
- **Privilese Super Admin**: Akses khusus untuk mengelola admin lain dan pengaturan sistem (Role-based access control).

---

## 🛠️ Teknologi yang Digunakan (Tech Stack)

Aplikasi ini menggunakan teknologi modern terbaik dalam pengembangan web:

### Backend
* **[Laravel 11.x](https://laravel.com/)**: *Framework* PHP mutakhir untuk logika peladen.
* **PHP 8.2 / 8.3**: Menjalankan *backend* dengan sangat efisien.
* **MySQL / SQLite**: Pangkalan data relasional teruji.

### Frontend
* **[Tailwind CSS](https://tailwindcss.com/)**: *Framework styling utility-first* untuk antarmuka yang bersih, modern, dan sangat responsif (*mobile-friendly*).
* **[Vite](https://vitejs.dev/)**: *Bundler* aset (CSS & JS) super cepat.
* **Vanilla JavaScript & Alpine.js**: Menangani interaktivitas *timer*, pemutar audio, dan *modals* dengan sangat ringan tanpa harus memuat ulang halaman (*Single-page feel*).
* **Phosphor Icons / Heroicons**: Kumpulan ikon elegan untuk UI.

---

## 🚀 Panduan Instalasi (Lokal)

Jika Anda ingin menjalankan atau mengembangkan situs ini di komputer pribadi Anda (localhost):

### Prasyarat
* PHP >= 8.2
* Composer
* Node.js & npm (untuk Vite)
* MySQL Server (XAMPP / Laragon)

### Langkah-Langkah

1. **Unduh Repositori (Clone)**
   ```bash
   git clone https://github.com/celcious-cyber/toeflin-laravel.git
   cd toeflin-laravel
   ```

2. **Instal Dependensi (Vendor & Node Modules)**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin fail pengaturan dasar dan hasilkan kunci rahasia aplikasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *(Opsional: Sesuaikan pengaturan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di dalam fail `.env` jika Anda menggunakan MySQL)*

4. **Siapkan Database (Migrasi & Tabur Data)**
   Perintah ini akan membangun tabel-tabel sekaligus menaburkan (*seed*) data akun *default* serta rumusan konversi skor.
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Aplikasi**
   Buka 2 tab terminal terpisah dan jalankan kedua baris ini bersamaan:
   ```bash
   # Terminal 1 (Menjalankan peladen PHP lokal)
   php artisan serve
   
   # Terminal 2 (Merakit tampilan aset Tailwind CSS)
   npm run dev
   ```
   **Buka di Browser Anda:** `http://127.0.0.1:8000`

---

## 🔐 Akun Bawaan Sistem (Default Credentials)

Gunakan akun berikut untuk *login* setelah Anda berhasil melakukan `db:seed` di atas:

| Role | Email Login | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@toeflin.com` | `password` | Akses tak terbatas. |
| **Admin** | `admin@toeflin.com` | `password` | Akses penuh untuk mengelola soal & peserta. |
| **Peserta/Mahasiswa** | `student@toeflin.com` | `password` | Akun peserta tes percobaan. |

> **⚠️ Penting:** Pastikan Anda langsung mengganti *password* akun Super Admin jika ini dipasang di peladen produksi (*live hosting*).

---

## ☁️ Catatan Instalasi (Shared Hosting)

Jika Anda mendesebarkan (deploy) aplikasi ini ke *Shared Hosting* cPanel/Hostinger:
1. Pastikan fitur **Node.js** tersedia untuk menjalankan `npm install` dan `npm run build` sebelum di-*zip*, atau _build_ di lokal terlebih dahulu.
2. Gunakan perintah `php artisan optimize:clear` setiap kali ada perubahan file konfigurasi atau pembaruan kode melalui git.
3. Sambungkan *Symlink Storage* jika audionya tidak bisa terputar. Aplikasi ini telah dilengkapi *bypass controller audio* bawaan untuk menangani *shared hosting* yang tidak mendukung symlink.

---
**TOEFLin** — *Dibuat dengan sepenuh hati untuk membantu mahasiswa menaklukkan TOEFL.*
