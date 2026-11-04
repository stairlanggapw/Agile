# Bioskop Stefanus Suka Mundur

Website bioskop sederhana berbasis **PHP native** dan **MySQL** yang menyediakan halaman login, registrasi, daftar jadwal film untuk pengguna, serta dashboard admin untuk melihat data pengguna.

Project ini dibuat sebagai tugas/eksplorasi pengembangan web dan dirancang untuk dijalankan secara lokal menggunakan **XAMPP**.

---

## Fitur

### Autentikasi
- Registrasi akun baru dengan username, email, dan password.
- Login menggunakan **username atau email**.
- Password disimpan menggunakan `password_hash()` (bcrypt).
- Mendukung migrasi otomatis password lama (MD5/plain text) ke hash bcrypt saat pengguna berhasil login.
- Logout dengan konfirmasi.
- Redirect otomatis berdasarkan role:
  - `admin` → `admin/dashboard.php`
  - `user` → `home.php`

### Halaman Pengguna
- Hero section dengan sapaan nama pengguna.
- Tabel rekomendasi film yang menggabungkan data `master_film` dan `jadwal_tayang`.
- Pagination jadwal film (5 data per halaman).
- Menampilkan poster, genre, durasi, tanggal, jam, studio, dan harga tiket.
- Halaman detail film beserta daftar jadwal tayangnya.
- Tampilan responsif dengan navbar sticky dan dark theme.
- Fallback poster otomatis jika gambar film tidak ditemukan.

### Halaman Admin
- Dashboard admin dengan daftar pengguna.
- Proteksi halaman admin berdasarkan role.
- Menu pengaturan film, jadwal, berita, users, dan laporan (masih berupa halaman dasar/placeholder).

---

## Teknologi

| Kategori | Teknologi |
|---|---|
| Bahasa Backend | PHP (native, `mysqli`) |
| Database | MySQL / MariaDB |
| Frontend | HTML5, CSS3, JavaScript |
| Ikon | [Ionicons](https://ionicons.com/) via CDN |
| Font | Google Fonts (Manrope, Poppins) |
| Web Server | Apache (XAMPP) |

> `package.json` berisi dependency `@tailwindcss/vite`, tetapi saat ini styling utama masih ditulis manual di file CSS/PHP dan belum menggunakan proses build Tailwind.

---

## Struktur Project

```text
Design_Login/
├── admin/                  # Area dashboard admin
│   ├── berita.php          # Pengaturan berita (placeholder)
│   ├── dashboard.php       # Dashboard + daftar pengguna
│   ├── film.php            # Pengaturan film (placeholder)
│   ├── jadwal.php          # Pengaturan jadwal (placeholder)
│   ├── laporan.php         # Laporan (placeholder)
│   ├── main.js             # Konfirmasi logout admin
│   └── users.php           # Manajemen pengguna (placeholder)
├── assets/
│   ├── background.jpg      # Background halaman login/register
│   ├── Cinima.jpg          # Background hero homepage
│   └── img/                # Poster film
├── auth/
│   ├── admin_auth.php      # Guard khusus admin
│   └── auth.php            # Guard halaman yang membutuhkan login
├── pages/
│   ├── berita.php          # Halaman berita (placeholder)
│   ├── detail.php          # Detail film + jadwal tayang
│   ├── film.php            # Halaman film (placeholder)
│   └── jadwal.php          # Halaman jadwal (placeholder)
├── home.php                # Dashboard pengguna
├── koneksi.php             # Koneksi database
├── login.php               # Form login
├── logout.php              # Proses logout
├── main.js                 # Script umum (logout, tombol form)
├── proses_login.php        # Proses autentikasi
├── proses_register.php     # Proses registrasi
├── registrasi.php          # Form registrasi
├── style.css               # Styling login & registrasi
├── package.json
└── README.md
```

---

## Persyaratan

- [XAMPP](https://www.apachefriends.org/) (PHP 8.x dan MySQL/MariaDB)
- Web browser modern
- Git (opsional, untuk clone repository)

---

## Instalasi

1. **Clone repository** ke folder `htdocs` XAMPP.

   ```bash
   cd C:\xampp\htdocs\website
   git clone https://github.com/stairlanggapw/Agile.git Design_Login
   ```

   Atau letakkan folder project langsung di:

   ```text
   C:\xampp\htdocs\website\Design_Login
   ```

   Jika project disimpan di lokasi lain, sesuaikan URL pada langkah 5.

2. **Jalankan Apache dan MySQL** melalui XAMPP Control Panel.

3. **Buat database** dengan nama `web` melalui phpMyAdmin, lalu import struktur tabel pada bagian [Skema Database](#skema-database).

4. **Sesuaikan koneksi database** di `koneksi.php` jika konfigurasi MySQL berbeda.

   ```php
   $hostname = "localhost";
   $username = "root";
   $password = "";
   $database_name = "web";
   ```

5. **Buka aplikasi** di browser:

   ```text
   http://localhost/website/Design_Login/login.php
   ```

6. **Registrasi akun** melalui halaman register, lalu login.

---

## Skema Database

Project ini menggunakan database `web` dengan tiga tabel utama. Struktur berikut merupakan contoh yang sesuai dengan query pada project:

```sql
CREATE DATABASE IF NOT EXISTS web;
USE web;

CREATE TABLE pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) DEFAULT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE master_film (
    id_film INT AUTO_INCREMENT PRIMARY KEY,
    judul_film VARCHAR(150) NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL,
    genre VARCHAR(100) DEFAULT NULL,
    durasi INT NOT NULL DEFAULT 0
);

CREATE TABLE jadwal_tayang (
    id_jadwal INT AUTO_INCREMENT PRIMARY KEY,
    id_film INT NOT NULL,
    tanggal_tayang DATE NOT NULL,
    jam_tayang TIME NOT NULL,
    studio VARCHAR(50) NOT NULL,
    harga_tiket INT NOT NULL,
    FOREIGN KEY (id_film) REFERENCES master_film(id_film) ON DELETE CASCADE
);
```

### Menjadikan Akun sebagai Admin

Akun hasil registrasi otomatis memiliki role `user`. Untuk membuat akun admin, ubah role melalui phpMyAdmin atau jalankan query berikut:

```sql
UPDATE pengguna SET role = 'admin' WHERE username = 'username_kamu';
```

### Contoh Data Film

```sql
INSERT INTO master_film (judul_film, gambar, genre, durasi) VALUES
('Avengers: Endgame', 'Avengers.jpeg', 'Action, Adventure', 181),
('Dilan 1991', 'dilan.jpeg', 'Drama, Romance', 118),
('Spider-Man', 'spiderman.jpeg', 'Action, Adventure', 148);

INSERT INTO jadwal_tayang (id_film, tanggal_tayang, jam_tayang, studio, harga_tiket) VALUES
(1, '2026-11-05', '13:00:00', 'Studio 1', 50000),
(1, '2026-11-05', '18:30:00', 'Studio 2', 55000),
(2, '2026-11-06', '15:00:00', 'Studio 1', 45000);
```

> Sesuaikan `id_film` dengan ID yang dihasilkan dari tabel `master_film`.

---

## Cara Menggunakan

1. Registrasi akun baru.
2. Login menggunakan username/email dan password.
3. Pengguna biasa akan diarahkan ke `home.php` untuk melihat rekomendasi film.
4. Klik **Lihat Detail** untuk melihat jadwal tayang dan harga tiket film.
5. Admin akan diarahkan ke dashboard admin setelah login.
6. Gunakan tombol **Keluar** untuk logout.

---

## Status Pengembangan

Sudah berfungsi:

- Registrasi, login multi-role, dan logout.
- Dashboard pengguna dengan daftar jadwal film dan pagination.
- Halaman detail film dan jadwal tayang.
- Dashboard admin dan daftar pengguna.

Belum diimplementasikan / masih placeholder:

- Halaman `pages/film.php`, `pages/jadwal.php`, dan `pages/berita.php`.
- Halaman admin `film.php`, `jadwal.php`, `berita.php`, `users.php`, dan `laporan.php`.
- Fitur pencarian film pada homepage (form sudah ada, proses query belum).
- Fitur pembayaran tiket (tombol menuju `#`).
- Fitur lupa password dan remember me.
- CRUD data film, jadwal, berita, dan pengguna dari dashboard admin.

---

## Catatan Keamanan

- Konfigurasi database menggunakan kredensial default XAMPP (`root` tanpa password). Jangan gunakan konfigurasi ini di lingkungan produksi.
- Query login, registrasi, dan detail film sudah menggunakan prepared statement.
- Password baru disimpan dengan `password_hash()`. Dukungan password lama (MD5/plain text) hanya untuk migrasi, bukan untuk penyimpanan data baru.
- Sebaiknya tambahkan validasi input, CSRF protection, pembatasan percobaan login, dan konfigurasi error reporting yang sesuai sebelum digunakan secara publik.

---

## Author

**stairlanggapw**

- GitHub: [@stairlanggapw](https://github.com/stairlanggapw)

---

© 2026 stairlanggapw. All rights reserved.
