# Aplikasi Perpustakaan

Aplikasi manajemen perpustakaan sederhana yang dibangun dengan Laravel.

## 📋 Persyaratan Sistem

- PHP >= 8.3
- Composer
- MySQL
- Node.js & NPM

## 🚀 Langkah-langkah Instalasi

### 1. Clone Repository

```git
git clone https://github.com/wawanmain22/Library_App.git
```

### 2. Instalasi Dependencies

```bash
cd Library_App
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
- Buat database baru di MySQL
- Sesuaikan konfigurasi database di file `.env`

### 5. Migrasi Database

```bash
php artisan migrate --seed
```

### 6. Menjalankan Aplikasi

```bash
php artisan serve
npm run dev
```

## 📝 Fitur Utama

- Manajemen Buku
- Manajemen Anggota
- Peminjaman dan Pengembalian
- Pencarian Buku
- Laporan

## 🤝 Kontribusi

Kontribusi dan saran sangat diterima.

### Kontributor
1. RIDWAN SYARIF ABIDIN
2. FARIS IFTIKHAR ALFARISI
3. DARWAN
4. RANGGA DRIYA NUGRAHA
5. FADLY FATWA WINATA AL QOERUDIN
6. DHIKA MUNAWAR

## 🛠️ Console Commands

```bash
# Create Import Template
php artisan make:import-template

# Optional: Cache Commands (jika terjadi error)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optional: Clear Cache (jika terjadi error)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## 📄 Lisensi

Aplikasi ini berlisensi di bawah [MIT License](LICENSE).


