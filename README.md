# 🎬 Cinelist

Cinelist adalah aplikasi web berbasis **Laravel** untuk mengelola katalog film, ulasan, daftar tontonan, serta terintegrasi dengan **TMDB (The Movie Database) API**.

---

## 🛠️ Tech Stack & Features

* **Framework:** Laravel 11
* **Auth & Security:** Laravel Breeze & Spatie Laravel-Permission (Roles & Permissions)
* **Admin Dashboard:** AdminLTE 4
* **Styling:** Tailwind CSS & PostCSS
* **Build Tool:** Vite
* **External Integration:** TMDB (The Movie Database) API

---

## 🚀 Cara Instalasi & Menjalankan (Setup Guide)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal (Local Development):

### 1. Clone Repositori
```bash
git clone https://github.com/afagusta/cinelist.git
cd cinelist

2. Install Dependensi PHP & Node.js
Bash

composer install
npm install

3. Konfigurasi Environment (.env)

Salin file .env.example menjadi .env:
Bash

cp .env.example .env

Buka file .env dan sesuaikan konfigurasi Database serta Token API TMDB kamu:
Cuplikan kode

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinelist
DB_USERNAME=root
DB_PASSWORD=

# TMDB API Configuration
TMDB_TOKEN=your_tmdb_api_read_access_token_here

    Catatan TMDB API:
    Untuk mendapatkan TMDB_TOKEN, buat akun di The Movie Database (TMDB), buka bagian Account Settings > API, lalu salin API Read Access Token (v4 auth) milikmu ke dalam .env.

4. Generate Application Key
Bash

php artisan key:generate

5. Jalankan Migrasi & Seeder Database
Bash

php artisan migrate --seed

6. Build Asset & Jalankan Local Server

Buka dua jendela terminal terpisah:

    Terminal 1 (Vite Dev Server):
    Bash

    npm run dev

    Terminal 2 (Laravel Artisan Server):
    Bash

    php artisan serve

Akses aplikasi di browser kamu melalui URL: [http://127.0.0.1:8000](http://127.0.0.1:8000)
📡 Integrasi & Endpoint API

Cinelist memanfaatkan API TMDB untuk mengambil data film serta menyediakan endpoint internal berformat JSON:
1. External API (TMDB)

Aplikasi ini melakukan request HTTP ke TMDB API menggunakan Bearer Token (TMDB_TOKEN) yang diset di file .env.
2. Internal API Endpoints

    Mendapatkan Daftar Film: GET /api/movies

    Mendapatkan Detail Film: GET /api/movies/{id}

    Menambahkan Film (Auth Required): POST /api/movies

📝 Lisensi

Proyek ini dibuat untuk keperluan akademik dan pengembangan pribadi di bawah lisensi MIT License.
