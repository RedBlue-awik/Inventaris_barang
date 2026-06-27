
# Inventaris - App

## Posisi yang Dilamar
**Backend Developer**

---

## Deskripsi Aplikasi

Sistem Inventaris Barang adalah aplikasi berbasis web yang digunakan untuk mengelola inventaris perusahaan

### Fitur Utama : 
- Login, Register dan Logout [ Role : admin | gudang | staf ]
- Daashboard
- Manajemen User [ Khusus Admin ]
- CRUD Kategori [ Khusus Admin ]
- CRUD Supplier  [ Khusus Admin ]
- CRUD Barang [ Staf hanya bisa melihat data barang ]
- CRUD Permintaan [ Staf hanya bisa melihat dan membuat permintaan sedangkan admin dan gudang bisa menyetujui dan menolak permintaan ]
- CRUD Mutasi Barang [ Khusus Admin dan Gudang ]
- Membuat permintaan yang disetujui otomatis berubah ke diserahkan dan menambah Mutasi Barang secara otomatis

---

## Teknologi & Library yang Digunakan 

| Teknologi | Versi |
|-----------|--------|
| PHP | 8.5+ |
| Laravel | 13.x |
| MySQL | 8.x |
| Tailwind CSS | 4.x |
| Composer | 2.10.1 |
| Node.js | 24.18.0 |

| Library | Versi |
|-----------|--------|
| Font Awesome | 7.0.1 |
| SweetAlert 2 | 11.x |
| Datatables | 2.0.8 |
| Datatables Responsive | 3.0.2 |
| Bootstrap | 5.2.3 |
| Poppeer.js | 2.11.6 |
| JQuery | 3.7.1 |


## Instalasi Aplikasi

### 1. Clone Repository 

```bash
git clone https://github.com/RedBlue-awik/Inventaris_barang.git
```
### 2. Masuk ke Folder Project

```bash
cd Inventaris_barang
```
### 3. Install Composer & npm

```bash
composer install

npm instal
```
### 4. Salin File Environment atau .env

```bash
cp .env.example .env
```

### 5. Generate APP_KEY

```bash
php artisan key:generate
```

### 6. Jalankan Migration & Seeder
```bash
php artisan migrate

php artisan db:seed
```
**atau**
```bash
php artisan migrate --seed
```

### 7. Jalankan Server
```bash
composer run dev
```
## Cara Mengakses Aplikasi

***Buka browser dan akses :***
```
http://127.0.0.1:8000
```

atau

```
http://localhost:8000
```

### 8. Schedule ( disetujui ke diserahkan dan membuat mutasi_barang secara otomatis )
## Cara menjalankan schedule
```bash
php artisan schedule:work
```
**Nanti Schedule akan dijalankan setiap 1 jam nya**

---

## Screenshot 

### login


![Login](image/login.png)

### Dashboard 

**- Dashboard Admin -**

![Dashboard-Admin](image/dashboard-admin.png)

**- Dashboard Gudanng -**

![Dashboard-Gudang](image/dashboard-gudang.png)

**- Dashboard Staf -**

![Dashboard-Staf](image/dashboard-staf.png)

### Master Data
**- Mutasi Barang -**

![Mutasi_Barang](image/mutasi_barang.png)

**- User -**

![Manajemen_Users](image/user.png)


---

## Hak Akses

### Admin

- Dashboard
- Barang ( bisa melihat, menambah, mengedit dan menghapus data barang )
- Kategori
- Supplier
- Permintaan ( bisa melihat semua permintaan dan menolak atau menyetujui permintaan )
- Mutasi Barang
- User

### Gudang

- Dashboard
- Barang ( bisa melihat, menambah, mengedit dan menghapus data barang )
- Permintaan ( bisa melihat semua permintaan dan menolak atau menyetujui permintaan )
- Mutasi Barang

### Staf
- Dashboard
- Barang ( melihat barang )
- Permintaan ( membuat permintaan dan hanya bisa melihat permintaan sendiri )

---
