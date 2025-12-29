# Panduan Upload ke Hosting (DeepBlog CMS) 🚀

Ada dua cara untuk menaruh website ini ke hosting:
1.  **Cara Modern (Rekomendasi)**: Menggunakan Git (karena kode sudah ada di GitHub).
2.  **Cara Manual**: Upload file Zip.

---

## OPSI 1: Menggunakan Git (Paling Mudah Update) 🐙
Jika hosting Bapak support Terminal / SSH atau menu "Git Version Control" (cPanel).

### Langkah-langkah:
1.  Masuk ke **Terminal** di cPanel atau SSH.
2.  Masuk ke folder `public_html` (atau folder tujuan):
    ```bash
    cd public_html
    ```
3.  **Clone Project**:
    ```bash
    git clone https://github.com/OzanProject/CMS_BLOG.git .
    ```
    *(Tanda titik `.` artinya clone ke folder saat ini. Pastikan folder kosong. Jika tidak kosong, clone ke folder baru lalu pindahkan isinya).*

4.  **Install Dependencies**:
    ```bash
    composer install --optimize-autoloader --no-dev
    ```

5.  **Setup Environment (.env)**:
    *   Copy file contoh: `cp .env.example .env`
    *   Edit `.env`: `nano .env` (atau edit lewat File Manager cPanel).
    *   Isi data database hosting (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    *   Set `APP_URL=https://domainbapak.com`
    *   Set `APP_DEBUG=false`

6.  **Generate Key & Migrate**:
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```

7.  **Storage Link** (Wajib biar gambar muncul):
    ```bash
    php artisan storage:link
    ```

### Cara Update Nanti:
Kalau besok saya update fitur baru, Bapak cukup ketik ini di terminal hosting:
```bash
git pull origin main
php artisan migrate
```
*Selesai! Website langsung update otomatis.*

---

## OPSI 2: Cara Manual (Upload Zip) 📦
Gunakan cara ini jika hosting **tidak ada akses git/terminal**.

### 1. Persiapan File (Di Laptop)
- [ ] **Backup Database**: Download file `.sql` dari Admin Panel Local.
- [ ] **Compress Codingan**: Zip semua folder `cms-blog-new`.
  - **PENTING**: Folder `node_modules` JANGAN diikutkan (berat).
  - Folder `vendor` BOLEH diikutkan jika di hosting tidak bisa run `composer install`.

### 2. Upload ke Hosting
- [ ] Upload zip ke File Manager cPanel.
- [ ] Extract file.
- [ ] Jika folder `public` Laravel ingin dijadikan root (agar domain langsung buka web tanpa `/public`), pindahkan **isi** folder `public` ke `public_html`.
  - Lalu edit `index.php` di `public_html`, sesuaikan path:
    `require __DIR__.'/../cms-blog-new/vendor/autoload.php';`

### 3. Database & Setting
- [ ] Buat database baru di cPanel.
- [ ] Import file `.sql` via phpMyAdmin.
- [ ] Edit file `.env` sesuaikan dengan database hosting.

### 4. Storage Link (Tanpa Terminal)
Buat Route sementara di `routes/web.php` lalu buka di browser sekali:
```php
Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'Link linked';
});
```
*Setelah dibuka dan muncul tulisan "Link linked", hapus route ini.*

---

## Checklist Akhir (PENTING) ✅
Apapun caranya, pastikan ini sudah beres:
1.  **Permission**: Folder `storage` dan `bootstrap/cache` harus **Writable** (775/755).
2.  **APP_URL**: Pastikan di `.env` pakai `https://`.
3.  **Debug Mode**: Pastikan `APP_DEBUG=false` biar aman.
