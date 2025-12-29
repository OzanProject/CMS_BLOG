# Panduan Upload ke Hosting (DeepBlog CMS) 🚀

Dokumen ini adalah checklist persiapan sebelum Bapak upload website ke cPanel atau VPS.

## 1. Persiapan File (Di Komputer Lokal)
Mengingat ini Laravel, struktur folder di hosting sedikit berbeda dengan di Laragon.

- [ ] **Backup Database**: Buka Admin > System > Backup. Download file `.sql` terbaru.
- [ ] **Compress Codingan**: Zip semua folder project (`cms-blog-new`), **KECUALI** folder:
  - `node_modules` (Terlalu besar, tidak dipakai di hosting)
  - `vendor` (Bisa ikut di-zip, tapi lebih baik install ulang pakai composer di hosting jika akses SSH ada. Kalau hosting biasa (shared), ikutkan saja `vendor` di dalam file zip biar praktis).
  - `.git` (Jika tidak pakai git)

## 2. Di cPanel / File Manager Hosting
- [ ] **Upload File Zip**: Upload ke folder `public_html` atau buat folder baru misal `cms-blog`.
- [ ] **Extract**: Ekstrak file zip.
- [ ] **Setting Folder Public**:
  - *Opsi Shared Hosting Biasa*: Pindahkan **isi** folder `public` milik Laravel ke root domain (`public_html`).
  - Edit file `index.php` yang baru dipindah:
    ```php
    // Ganti baris ini:
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // Menjadi (sesuaikan path folder project bapak):
    require __DIR__.'/cms-blog-new/vendor/autoload.php';
    $app = require_once __DIR__.'/cms-blog-new/bootstrap/app.php';
    ```

## 3. Konfigurasi Database
- [ ] **Buat Database Baru**: Di menu "MySQL Databases" cPanel.
- [ ] **Import Database**: Buka phpMyAdmin, pilih database baru, lalu **Import** file `.sql` yang tadi didownload dari Admin Panel.
- [ ] **Edit .env**: Edit file `.env` di hosting:
  ```env
  APP_URL=https://namadomainbapak.com
  APP_ENV=production
  APP_DEBUG=false (PENTING: Biar error tidak kelihatan pengunjung)
  
  DB_DATABASE=nama_db_hosting
  DB_USERNAME=user_db_hosting
  DB_PASSWORD=password_db_hosting
  ```

## 4. Storage Link (PENTING UNTUK GAMBAR) 🖼️
Karena di hosting strukturnya berubah, symlink gambar biasa putus.
- [ ] **Hapus Folder Storage Lama**: Hapus folder `storage` yang ada di dalam `public_html` (symlink-nya).
- [ ] **Buat Symlink Baru**:
  - Jika ada akses Terminal/SSH: Jalankan `php artisan storage:link`
  - Jika TANPA SSH: Buat Route sementara di `routes/web.php`:
    ```php
    Route::get('/link', function () {
        Artisan::call('storage:link');
        return 'Link created';
    });
    ```
    Buka `namadomain.com/link` sekali, lalu hapus route itu.

## 5. Cek Terakhir
- [ ] **Clear Cache**: Di hosting, sebaiknya bersihkan cache config lama.
  - Hapus file di `bootstrap/cache/*.php`.
- [ ] **Permission**: Pastikan folder `storage` dan `bootstrap/cache` permission-nya **775** atau **755** (Writable).

---
**Catatan Tambahan**:
Karena kita pakai fitur **Open Graph & Caching**, pastikan `APP_URL` di `.env` hosting benar-benar `https://...` (pakai 's'), supaya gambar sosmed muncul!
