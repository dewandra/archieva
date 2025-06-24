# Archievault - Sistem Manajemen Arsip Surat

<p align="center">
  <img src="public/img/archievault.png" alt="Archievault Logo" width="400">
</p>

<p align="center">
  Aplikasi web modern untuk manajemen arsip surat masuk, surat keluar, dan disposisi secara digital. Dibangun dengan TALL Stack (Laravel, Livewire) dan Bootstrap 5.
</p>

## Tentang Proyek

**Archievault** adalah solusi digital untuk menggantikan proses manual dalam pengelolaan arsip surat di lingkungan kantor atau organisasi. Aplikasi ini dirancang untuk mempermudah pencatatan, pencarian, dan pelacakan alur surat, mulai dari surat masuk hingga disposisi ke bidang terkait. Dengan antarmuka yang bersih dan responsif, Archievault bertujuan untuk meningkatkan efisiensi dan mengurangi penggunaan kertas.

Proyek ini dibangun menggunakan:
* **Backend:** Laravel 11
* **Frontend:** Livewire 3 & Bootstrap 5
* **Build Tool:** Vite

## Fitur Utama

-   **Dashboard Interaktif:** Menampilkan ringkasan jumlah surat masuk, keluar, dan request, beserta grafik mingguan.
-   **Manajemen Surat Masuk:** CRUD (Create, Read, Update, Delete) untuk data surat masuk, lengkap dengan upload lampiran dan detail disposisi.
-   **Manajemen Surat Keluar:** Pencatatan buku agenda untuk surat keluar.
-   **Request Surat:** Fitur bagi user 'Bidang' untuk mengajukan request penomoran surat.
-   **Manajemen Pengguna & Role:** Sistem Role-Based Access Control dengan 3 tingkatan:
    1.  **Admin:** Akses penuh ke semua fitur.
    2.  **Arsip:** Akses ke fitur manajemen surat.
    3.  **Bidang:** Akses terbatas hanya untuk request surat dan melihat status.
-   **Profil Pengguna:** Pengguna dapat mengubah data pribadi dan password.
-   **Desain Responsif:** Tampilan yang optimal di perangkat desktop maupun mobile.

## Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

1.  **Clone repository**
    ```sh
    git clone [https://github.com/dewandra/archieva.git](https://github.com/dewandra/archieva.git)
    cd archieva
    ```

2.  **Install dependensi PHP**
    ```sh
    composer install
    ```

3.  **Buat file `.env`**
    ```sh
    cp .env.example .env
    ```

4.  **Generate application key**
    ```sh
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

6.  **Jalankan Migrasi & Seeder**
    Perintah ini akan membuat struktur tabel dan mengisi data awal (user admin).
    ```sh
    php artisan migrate --seed
    ```

7.  **Install dependensi Node.js**
    ```sh
    npm install
    ```

8.  **Jalankan Vite development server**
    ```sh
    npm run dev
    ```

9.  **Jalankan server Laravel**
    Buka terminal baru dan jalankan:
    ```sh
    php artisan serve
    ```

10. **Akses Aplikasi**
    Buka browser Anda dan kunjungi `http://127.0.0.1:8000`.

## Akun Demo

Setelah menjalankan `migrate --seed`, Anda bisa login menggunakan akun berikut:

-   **Email:** `test@example.com`
-   **Password:** `password`

Anda dapat mengubah role pengguna ini melalui halaman "Users" untuk mencoba akses sebagai role yang berbeda.

## Lisensi

Proyek Archievault adalah perangkat lunak sumber terbuka yang dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).