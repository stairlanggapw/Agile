# Design-Login

# 🎨 Design-Login

Sebuah website login yang modern, responsif, dan user-friendly dengan desain yang elegan dan minimal.

**Live Demo:** [https://stairlanggapw.github.io/Design-Login/](https://stairlanggapw.github.io/Design-Login/)

---

## 📋 Daftar Isi

- [Fitur](#fitur)
- [Screenshot](#screenshot)
- [Teknologi](#teknologi)
- [Instalasi](#instalasi)
- [Struktur File](#struktur-file)
- [Penggunaan](#penggunaan)
- [Customization](#customization)
- [Browser Support](#browser-support)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

---

## ✨ Fitur

- ✅ **Design Modern & Minimalis** - Interface yang bersih dan menarik
- ✅ **Responsive Design** - Tampilan sempurna di semua perangkat (mobile, tablet, desktop)
- ✅ **Form Validation** - Validasi input untuk email dan password
- ✅ **Remember Me** - Fitur ingat password dengan checkbox
- ✅ **Forgot Password** - Link untuk recovery password
- ✅ **Register Link** - Navigasi ke halaman registrasi
- ✅ **CSS Modern** - Menggunakan Flexbox dan Grid untuk layout yang fleksibel
- ✅ **Smooth Animations** - Transisi dan animasi yang halus

---

## 📸 Screenshot

Aplikasi menampilkan halaman login yang elegan dengan:
- Form input untuk email dan password
- Checkbox "Remember me"
- Tombol login yang responsif
- Link "Forgot Password"
- Redirect ke halaman register

---

## 🛠️ Teknologi

Proyek ini dibangun menggunakan teknologi dasar web:

| Teknologi | Keterangan |
|-----------|-----------|
| **HTML5** | Struktur semantic markup |
| **CSS3** | Styling dengan Flexbox & Grid |
| **JavaScript** | Interaktivitas dan validasi form |
| **GitHub Pages** | Hosting gratis |

---

## 🚀 Instalasi

### Prasyarat
- Browser modern (Chrome, Firefox, Safari, Edge)
- Text editor (VS Code, Sublime Text, dll)
- Git (opsional, untuk cloning)

### Langkah-langkah

#### 1. Clone Repository
```bash
git clone https://github.com/stairlanggapw/Design-Login.git
cd Design-Login
```

#### 2. Buka di Browser
Buka file `index.html` langsung di browser atau gunakan Live Server:

**Menggunakan VS Code Live Server:**
1. Install extension "Live Server" dari VS Code
2. Klik kanan pada `index.html`
3. Pilih "Open with Live Server"
4. Browser akan otomatis membuka di `http://localhost:5500`

#### 3. Atau Akses Online
Langsung kunjungi: https://stairlanggapw.github.io/Design-Login/

---

## 📂 Struktur File

```
Design-Login/
├── index.html          # Halaman login utama
├── regis.html          # Halaman registrasi (jika ada)
├── css/
│   └── style.css       # File styling utama
├── js/
│   └── script.js       # File JavaScript untuk interaktivitas
├── assets/
│   └── (images, icons) # Aset visual
├── README.md           # Dokumentasi ini
└── LICENSE             # Lisensi proyek
```

---

## 💻 Penggunaan

### Halaman Login
1. Masukkan email Anda di field "Email"
2. Masukkan password di field "Password"
3. (Opsional) Centang "Remember me" untuk menyimpan login
4. Klik tombol "Login"
5. Jika belum memiliki akun, klik "Register"

### Customization

#### Mengubah Warna
Edit file `css/style.css` dan ubah variabel warna:
```css
:root {
  --primary-color: #4CAF50;      /* Warna utama */
  --secondary-color: #f1f1f1;    /* Warna sekunder */
  --text-color: #333;            /* Warna teks */
}
```

#### Mengubah Font
Tambahkan Google Fonts di `<head>` HTML:
```html
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
```

#### Mengubah Logo/Gambar
Ganti path gambar di `index.html`:
```html
<img src="assets/your-logo.png" alt="Logo">
```

---

## 🔐 Validasi Form

Proyek ini menggunakan validasi dasar HTML5 dan JavaScript:

```javascript
// Contoh validasi email
function validateEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}
```

---

## 🌐 Browser Support

| Browser | Support |
|---------|---------|
| Chrome | ✅ Latest |
| Firefox | ✅ Latest |
| Safari | ✅ Latest |
| Edge | ✅ Latest |
| IE 11 | ⚠️ Limited |

---

## 📱 Responsive Breakpoints

```css
/* Mobile (< 768px) */
@media (max-width: 767px) {
  /* Mobile styles */
}

/* Tablet (768px - 1024px) */
@media (min-width: 768px) and (max-width: 1024px) {
  /* Tablet styles */
}

/* Desktop (> 1024px) */
@media (min-width: 1025px) {
  /* Desktop styles */
}
```

---

## 🔧 Development

Jika ingin mengembangkan lebih lanjut:

1. **Tambah fitur login dengan backend**
   - Gunakan Node.js + Express
   - Integrasikan dengan database (MongoDB, MySQL)
   - Implementasikan JWT untuk authentication

2. **Tambah animasi**
   - Gunakan CSS animations atau library seperti AOS (Animate On Scroll)
   - Tambahkan transition yang smooth

3. **Improve Security**
   - Hash password dengan bcrypt
   - Implementasikan HTTPS
   - Tambah CSRF protection

---

## 🤝 Kontribusi

Kami menerima kontribusi dari siapa saja! Berikut cara berkontribusi:

1. **Fork** repository ini
2. **Buat branch** fitur baru
   ```bash
   git checkout -b feature/NamaFitur
   ```
3. **Commit** perubahan
   ```bash
   git commit -m "Add: Deskripsi fitur"
   ```
4. **Push** ke branch
   ```bash
   git push origin feature/NamaFitur
   ```
5. **Buat Pull Request**

---

## 📝 Lisensi

Proyek ini menggunakan lisensi **MIT**. Kamu bebas menggunakan, memodifikasi, dan mendistribusikan proyek ini dengan menyertakan notice lisensi asli.

Lihat file [LICENSE](LICENSE) untuk detail lengkap.

---

## 👨‍💻 Author

**Stairlanggapw**
- GitHub: [@stairlanggapw](https://github.com/stairlanggapw)
- Repository: [Design-Login](https://github.com/stairlanggapw/Design-Login)

---

## ❓ FAQ

**Q: Apakah proyek ini gratis?**
A: Ya, 100% gratis dan open source.

**Q: Bisakah saya menggunakan ini untuk komersial?**
A: Ya, sesuai dengan lisensi MIT.

**Q: Bagaimana cara menghubungkan dengan backend?**
A: Gunakan Fetch API atau Axios untuk mengirim data ke server Anda.

**Q: Apakah ada demo online?**
A: Ya, kunjungi https://stairlanggapw.github.io/Design-Login/

---

## 🐛 Report Bug

Jika menemukan bug, silakan buka [issue baru](https://github.com/stairlanggapw/Design-Login/issues) dengan detail:
- Deskripsi bug
- Steps untuk reproduce
- Screenshot (jika perlu)
- Browser dan versi yang digunakan

---

## 💡 Saran & Fitur Baru

Punya ide bagus? Silakan diskusikan di [discussions](https://github.com/stairlanggapw/Design-Login/discussions).

---

**⭐ Jika proyek ini bermanfaat, jangan lupa kasih bintang!**

Made with ❤️ by Stairlanggapw
