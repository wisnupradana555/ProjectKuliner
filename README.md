# ProjectKuliner — Lokasi Kuliner & Review Jajanan
Aplikasi web berbasis **CodeIgniter 4** untuk menemukan, menambahkan, dan me-review tempat kuliner di sekitar kampus Universitas Dian Nuswantoro Semarang.

---

## Akun Demo
| Role | Email | Password |
|---|---|---|
| Admin | admin@admin.com | admin123 |
| Kontributor | user@user.com | user123 |

---

## Cara Instalasi & Menjalankan

```bash
# 1. Clone repository
git clone https://github.com/wisnupradana555/ProjectKuliner.git
cd ProjectKuliner

# 2. Install dependencies
composer install

# 3. Salin file konfigurasi
cp env .env

# 4. Edit .env — sesuaikan database
DB_HOST     = localhost
DB_DATABASE = db_kuliner
DB_USERNAME = root
DB_PASSWORD =

# 5. Jalankan migrasi & seeder
php spark migrate
php spark db:seed KulinerSeeder

# 6. Jalankan server
php spark serve
```

Buka browser: `http://localhost:8080`

---

## Fitur Utama
- Peta interaktif (Leaflet.js + OpenStreetMap) untuk melihat lokasi kuliner
- Multi-role: Admin, Kontributor, Pengunjung
- CRUD tempat kuliner + upload foto
- Sistem moderasi (approve/reject) oleh Admin
- Flash Message & Validasi Form
- Tanggal submit tercatat otomatis

---

## Webservice Server — API Endpoint (Point 6)

Base URL: `http://localhost:8080`

### Autentikasi
Semua request ke endpoint `/api/*` wajib menyertakan header:
```
X-API-Key: kuliner-api-key
```
Jika tidak disertakan atau salah, server akan mengembalikan response `401 Unauthorized`.

---

### Endpoint

#### 1. GET `/api/kuliner`
Mengambil daftar semua tempat kuliner yang sudah disetujui (approved).

**Query Parameter (Opsional):**
| Parameter | Tipe | Keterangan |
|---|---|---|
| `kategori` | integer | Filter berdasarkan ID kategori |

**Contoh Request:**
```
GET /api/kuliner
GET /api/kuliner?kategori=2
X-API-Key: kuliner-api-key
```

**Contoh Response:**
```json
{
    "status": "success",
    "total": 20,
    "data": [
        {
            "id": "41",
            "nama": "Burjo Sari Asih 2",
            "alamat": "Jl. Nakula I No.1, Semarang",
            "deskripsi": "Nasi, mie ayam, bakso murah meriah.",
            "lat": "-6.9824",
            "lon": "110.4086",
            "created_at": "2026-05-06 20:40:41",
            "kategori": "Warteg",
            "foto_url": null
        }
    ]
}
```

---

#### 2. GET `/api/kuliner/{id}`
Mengambil detail satu tempat kuliner berdasarkan ID.

**Contoh Request:**
```
GET /api/kuliner/41
X-API-Key: kuliner-api-key
```

**Contoh Response (200 OK):**
```json
{
    "status": "success",
    "data": {
        "id": "41",
        "nama": "Burjo Sari Asih 2",
        "alamat": "Jl. Nakula I No.1, Semarang",
        "kategori": "Warteg"
    }
}
```

**Contoh Response (404 Not Found):**
```json
{
    "status": "error",
    "message": "Data tidak ditemukan."
}
```

---

#### 3. GET `/api/kategori`
Mengambil daftar semua kategori kuliner.

**Contoh Request:**
```
GET /api/kategori
X-API-Key: kuliner-api-key
```

**Contoh Response:**
```json
{
    "status": "success",
    "total": 6,
    "data": [
        { "id": "1", "nama_kategori": "Warteg" },
        { "id": "2", "nama_kategori": "Kafe" }
    ]
}
```

---

## Tech Stack
- **Framework:** CodeIgniter 4
- **Database:** MySQL
- **Map:** Leaflet.js + OpenStreetMap
- **Frontend:** HTML, CSS, JavaScript (Vanilla)
