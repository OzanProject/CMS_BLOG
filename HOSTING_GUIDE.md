# Panduan Hosting: Struktur Folder Aman (DeepBlog CMS) 🚀

Sesuai permintaan, kita akan memisahkan folder **Project** (codingan) dengan folder **Public** (yang diakses pengunjung). Ini adalah struktur **paling aman**.

**Target Struktur:**
- `/home/ozanproj/cms-blog` -> Codingan Laravel ada di sini (Aman, tidak bisa diakses publik).
- `/home/ozanproj/public_html` -> Hanya isi folder `public` Laravel (index.php, gambar) yang ditaruh di sini.

---

## Langkah-langkah Penerapan

### 1. Masuk ke Terminal Hosting
Masuk ke root directory (`/home/ozanproj`).
Ketikan perintah ini:

```bash
cd /home/ozanproj
```

### 2. Clone Project (Di Luar public_html)
Kita download codingannya ke folder baru bernama `cms-blog`. Jangan di dalam `public_html`.

```bash
# Clone ke folder cms-blog
git clone https://github.com/OzanProject/CMS_BLOG.git cms-blog
```

### 3. Pindahkan Isi Token Public
Sekarang kita pindahkan **ISI** folder `public` dari project ke folder `public_html`.

**PENTING:** Pastikan `public_html` kosong dulu (kecuali file default cgi-bin).

```bash
# Pindahkan semua isi public ke public_html
cp -r /home/ozanproj/cms-blog/public/* /home/ozanproj/public_html/

# Copy juga file .htaccess (penting karena hidden file)
cp /home/ozanproj/cms-blog/public/.htaccess /home/ozanproj/public_html/
```

### 4. Edit index.php (KUNCI UTAMA) 🔑
Karena codingan pindah lokasi, kita harus kasih tahu `index.php` dimana file Laravel-nya berada.

1.  Buka File Manager atau `nano`.
2.  Edit file: `/home/ozanproj/public_html/index.php`.
3.  Ubah dua baris path `require`.

**Cari Baris Ini:**
```php
if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
```

**Ubah Menjadi (Arahkan ke folder cms-blog):**
```php
// Sesuaikan path ke maintenance mode
if (file_exists(__DIR__.'/../cms-blog/storage/framework/maintenance.php')) {
    require __DIR__.'/../cms-blog/storage/framework/maintenance.php';
}

// Arahkan ke folder cms-blog
require __DIR__.'/../cms-blog/vendor/autoload.php';

$app = require_once __DIR__.'/../cms-blog/bootstrap/app.php';
```

### 5. Install & Setup
Kembali ke terminal, masuk ke folder project untuk setup.

```bash
cd /home/ozanproj/cms-blog

# 1. Install Library
composer install --optimize-autoloader --no-dev

# 2. Setup Database (.env)
cp .env.example .env
nano .env 
# (Isi DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL=https://domain.com)

# 3. Generate Key
php artisan key:generate

# 4. Migrate Database
php artisan migrate --seed
```

### 6. Perbaiki Storage Link (Gambar) 🖼️
Ini bagian *tricky*. Folder `storage` ada di `/home/ozanproj/cms-blog/storage`, tapi kita butuh aksesnya di `/home/ozanproj/public_html/storage`.

Hapus symlink lama (jika ada) dan buat baru manual:

```bash
# Hapus folder storage di public_html (jika ada)
rm -rf /home/ozanproj/public_html/storage

# Buat link manual dari folder project ke public_html
ln -s /home/ozanproj/cms-blog/storage/app/public /home/ozanproj/public_html/storage
```

---

## 🛑 Pengecekan Terakhir
1.  Buka domain Bapak.
2.  Kalau muncul error "Permission Denied" pada folder Log/Storage:
    ```bash
    chmod -R 775 /home/ozanproj/cms-blog/storage
    chmod -R 775 /home/ozanproj/cms-blog/bootstrap/cache
    ```

Selesai! Dengan cara ini, kode inti Laravel Bapak aman tersembunyi di `/home/ozanproj/cms-blog`, sedangkan pengunjung hanya mengakses `/home/ozanproj/public_html`.
