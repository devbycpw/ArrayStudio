# Array Studio - Photography Management & Booking System

## 📸 Deskripsi Proyek
**Array Studio** adalah sebuah aplikasi web yang dirancang khusus untuk manajemen studio fotografi profesional. Sistem ini mengatasi segala hal mulai dari galeri publik untuk pemasaran/portofolio, layanan paket fotografi, hingga pemesanan (booking) online yang berkesinambungan dan pelacakan pembayaran manual. 

Tujuan utama dari sistem ini adalah menghapus proses pemesanan manual yang tidak teratur, serta memberikan impresi *premium* dan *professional* melalui antarmuka pengguna (UI) "Champagne Gold Light Theme".

---

## 💻 Tech Stack & Pustaka (Libraries)
Aplikasi ini dikembangkan dengan teknologi dasar dan beberapa pustaka pendukung untuk pengalaman (*Experience*) visual dan interaktif.

* **Backend / Logika Utama:** PHP (Native/Procedural)
* **Database Relasional:** MySQL (`photo_studio`)
* **Styling Framework:** Bootstrap 5 (Custom CSS)
* **Animasi UI:** AOS (*Animate On Scroll*) & CSS Keyframes
* **Library Ekstra UI:** 
  * **SweetAlert2** (Notifikasi Pop-Up Modern)
  * **Flatpickr** (Pemilihan Kalender/Tanggal)
  * **Chart.js** (Visualisasi data di Dashboard Admin)
  * **FullCalendar** (Pemantauan Jadwal Admin)
  * **Bootstrap Icons** (Sistem Ikonograsi)

---

## 🗂 Struktur Direktori
Proyek ini mengimplementasikan pemisahan modul *(Modularity)* yang ketat berdasarkan peran *(Roles)* dan hak akses pengguna.

```text
ArrayStudio/
   database.php            # Logika Koneksi database & Query Utama CRUD
   index.php               # Pintu masuk (Redirect ke general/home.php)
   
+---admin/                  # Modul Khusus Administrator 
       booking.php         # Persetujuan dan manajemen status booking klien
       dashboard.php       # Ringkasan data (Total Klien, Pemasukan, Grafik Chart.js)
       editService.php     # Edit pembaruan detail paket layanan foto
       gallery.php         # Sistem inventaris memori foto (Tabel gambar)
       scedhule.php        # Tampilan jadwal studio
       services.php        # Indeks paket harga/sistem layanan
       tambahGal.php       # Upload foto baru untuk Portofolio
       tambahService.php   # Pembuatan skema layanan foto baru
       
+---auth/                   # Modul Autentikasi Pengguna
       login.php           # Verifikasi Username & Password
       logout.php          # Terminasi sesi login (Session Destroy)
       register.php        # Pembuatan akun klien baru
       
+---client/                 # Modul Dasbor Khusus Klien Terdaftar
       booking.php         # Modul reservasi jadwal & deteksi bentrok (Flash Booking)
       home.php            # Tampilan beranda terautentikasi klien
       myGallery.php       # Galeri personal klien yang telah dikirim studio
       payment.php         # Ringkasan harga & Verifikasi Bank Transfer Manual
       services.php        # Katalog foto interaktif dengan aksi Booking
       
+---general/                # Modul Akses Publik (Tanpa Login)
       gallery.php     
       home.php            # Landing Page utama yang dioptimalkan dengan estetika
       services.php    
       
+---img/                    # Penyimpanan Aset Fotografi Lokal
       
+---layouts/                # Sistem Pembauran UI (Layout Engine)
       footer.php          # Kaki Halaman universal
       main.php            # Template HTML Induk (Head, Font, Stylesheets, AOS)
       navbarAdmin.php     # Navigasi Khusus Role Admin
       navbarClient.php    # Navigasi Khusus Role Client
       navbarGeneral.php   # Navigasi Publik
       
+---static/                 # Penyimpanan Berkas CSS Global
        style.css           # Core Styling (Tema, Variabel, Root, Utility)
```

---

## 🗄️ Database Schema & Fungsi Inti (`database.php`)

Relasi dibangun menggunakan database `photo_studio`.

1. **`users`**
   - Menampung seluruh pengguna platform, dipisahkan dari tabel melalui kolom `role` (`'admin'` atau `'client'`).
   - Menyimpan *hash* kata sandi melalui algoritma rahasia yang aman.

2. **`services`**
   - Mengontrol katalog layanan. Tabel mencatat ID, Nama Paket (Wedding, Portrait), Deskripsi, Harga Layanan.

3. **`gallery`**
   - Inventaris aset foto (`image_url`) yang bertugas mewakili katalog / portofolio website dengan metadata kategorisasi lokal. Menggunakan File-system `img/`.

4. **`bookings`**
   - Melacak transaksi sewa dengan parameter:
     - Relasi *Foreign* ke `id_user` & `id_service`.
     - `booking_date` & `booking_time`.
     - `status`: `'pending'` -> `'approved'` -> `'confirmed'`/`'paid'` -> `'completed'`.

---

## 🎨 Sistem Desain (*Design System*)
Array Studio mengadopsi pendekatan perancangan kontemporer untuk industri Fotografi, yakni mendemonstrasikan status *luxury/premium*:

* **Tema Warna (*Light Mode*)**: 
  * `var(--main-bg)`: Warna dasar Krim Lembut (`#FCFBF9`) mereduksi radiasi putih pada layar.
  * `var(--card-bg)`: Putih Gading (`#FFFFFF`) memberikan efek bayangan yang renyah.
* **Aksen Emas (*Champagne Gold*)**:
  * `var(--primary-gold)`: `#C5A880`, warna kancing panggilan menuju aksi *(CTA)* yang berkelas.
  * `var(--text-primary)`: Abu-abu gelap karbon (`#2C303A`) mencegah kontras hitam murni yang terlalu tajam.
* **Tipografi**:
  * Menggabungkan *Playfair Display* (klasik dan tajam untuk judul/hero) dengan *Poppins* (modern dan sans-serif untuk teks informasional).

---

## 🚀 Panduan Alur Kerja (Workflow)

### Alur Klien (Client Flow)
1. **Pendaftaran (Onboarding)**: Pengunjung membuat akun di `/auth/register.php`.
2. **Katalog (Cataloging)**: Klien melihat `services.php` atau Portofolio, memilih gaya pemotretan idaman.
3. **Pemesanan (Booking)**: Klien menuju `/client/booking.php`. Form akan mencegah pemilihan tanggal/waktu yang sama (mendeteksi bentrok / *schedule conflict*).
4. **Penyelesaian Transaksi (Payment)**: Setelah Admin mengubah status dari `pending` ke `approved`, Klien melanjutkan ke `payment.php`.
5. **Konfirmasi (Confirmation)**: Klien melihat rincian Transfer Bank, mengklik *"Saya Sudah Bayar"*, status berubah menjadi `confirmed`.

### Alur Admin (Admin Flow)
1. Karyawan *Studio* melakukan login ke URL rahasia sebagai Administrator.
2. Dihadapkan dengan `dashboard.php` grafis yang menampilkan statistik Pemasukan & Pertumbuhan Klien.
3. Di `booking.php`, Admin dapat melihat semua pesanan yang menumpuk. Dapat melakukan fungsi *Approve* (ACC) atau *Reject* pesanan.
4. Lewat `tambahService.php` dan `tambahGal.php`, admin mengurus stok harga dan citra portofolio baru.
