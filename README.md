# 🚀 Qora Bug Tracker (Enterprise Level)

Sistem manajemen pelaporan bug (Bug Tracking System) Full-Stack yang dirancang dengan standar industri. Aplikasi ini memisahkan antara antarmuka Frontend (HTML/Vanilla JS) dan Backend (RESTful API Laravel) yang terintegrasi secara asinkron (AJAX/Fetch).

## 🛠️ Tech Stack
- **Backend:** Laravel 11 (REST API), Sanctum (Authentication)
- **Database:** PostgreSQL
- **Frontend:** HTML5, CSS3 (Bootstrap 5), Vanilla JavaScript
- **Mailing:** SMTP Mailtrap
- **Storage:** Local File Storage (Laravel Storage Link)

## ✨ Fitur Utama
1. **Sistem Autentikasi API:** Menggunakan Laravel Sanctum berbasis Token.
2. **Manajemen Tiket Bug (CRUD):** Pembuatan, pembacaan, pembaruan status, dan pencarian tiket bug.
3. **Penyimpanan Bukti (Evidence):** Mendukung fitur unggah file gambar (Screenshot error) menggunakan `FormData`.
4. **Notifikasi Email Otomatis:** Sistem akan mengirimkan email via Mailtrap kepada pelapor saat status bug diubah.
5. **Log Aktivitas (Audit Trail):** Mencatat setiap perubahan data ke dalam tabel history secara otomatis.
6. **Real-time Dashboard:** Menampilkan statistik interaktif tanpa perlu *reload* halaman.

## 📸 Screenshot Aplikasi

<!-- SILAKAN DRAG & DROP GAMBAR SCREENSHOT DASBOR UTAMA DI BAWAH BARIS INI: -->
<img width="2878" height="1305" alt="Screenshot 2026-10-20 115552" src="https://github.com/user-attachments/assets/8772c6d0-791c-4593-bc86-b1d4e10d4309" />


<!-- SILAKAN DRAG & DROP GAMBAR MODAL FORM/BUKTI GAMBAR DI BAWAH BARIS INI: -->
<img width="1212" height="1200" alt="Screenshot 2026-10-20 115604" src="https://github.com/user-attachments/assets/103de2c9-1a41-486b-af0f-7a70cb47821e" />

<!-- SILAKAN DRAG & DROP GAMBAR NOTIFIKASI EMAIL MAILTRAP DI BAWAH BARIS INI: -->
<img width="612" height="530" alt="Screenshot 2026-10-20 115630" src="https://github.com/user-attachments/assets/e18000f0-68dc-4f19-b9e9-ff587f83fe86" />


## 🚀 Cara Menjalankan Secara Lokal (Local Setup)

### 1. Setup Backend (Laravel)
```bash
cd qora-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

### 2. Setup Frontend
-Buka file dashboard-qora.html menggunakan Live Server di VS Code atau langsung klik dua kali file tersebut (Open in Browser).

-Pastikan sudah melakukan Login via endpoint API (menggunakan Thunder Client / Postman) untuk mendapatkan Token Sanctum.

-Masukkan token tersebut ke dalam variabel myToken di dalam file dashboard-qora.html.

####🚀 Roadmap (Upcoming Features)
[ ] Membangun antarmuka Halaman Login & Register (UI) mandiri agar tidak bergantung pada Postman/Thunder Client.

[ ] Integrasi fitur Search dan Pagination API langsung ke dalam tabel Dashboard HTML.

[ ] Menambahkan pop-up detail Log Aktivitas untuk setiap bug.
