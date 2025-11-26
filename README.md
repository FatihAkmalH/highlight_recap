# 📊 Highlight Competitor — Recap Management System

![Status](https://img.shields.io/badge/Status-Active-brightgreen)
![License](https://img.shields.io/badge/License-MIT-blue)
![PHP](https://img.shields.io/badge/PHP-8.x-%23777BB4)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2F8.0-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![jQuery](https://img.shields.io/badge/jQuery-3.7-blue)

---

## 📷 Screenshot UI

### 🌞 Screenshoot UI
![Simple UI](/ss_UI.png)

---

## 📘 Deskripsi
Highlight Competitor adalah aplikasi web untuk membuat, menyimpan, dan melakukan monitoring recap harian seperti:

- Notes  
- Movie  
- Sports  
- New Program  
- Program Special  
- Series  

Aplikasi ini juga dilengkapi dengan:

✔ Real-time typing indicator  
✔ Auto polling perubahan highlight  
✔ Simpan otomatis dengan `ON DUPLICATE KEY UPDATE`  
✔ Copy hasil recap ke clipboard  
✔ Modal input nama (tersimpan di localStorage + session server)  

---

## 🏗️ Fitur Utama

### ✏️ 1. Form Input Recap  
User dapat menuliskan highlight berdasarkan kategori.

### 🔄 2. Auto Save / Update  
Menggunakan query berikut:

```sql
INSERT ... ON DUPLICATE KEY UPDATE
```

### 🪄 3. Live Typing Indicator  
Menampilkan siapa saja yang sedang mengetik menggunakan:

- `typing.php`
- `typing_status.php`

### 🌐 4. Hash-based Auto Refresh  
File `hash.php` akan membangkitkan hash MD5 dari data recap.  
Jika isi recap berubah, output di sebelah kanan akan otomatis diperbarui.

### 📋 5. Copy to Clipboard  
Output recap bisa disalin ke clipboard secara instan.

---

## 📁 Struktur Proyek
silahkan kalian dapat rapihkan sesuai kemauan kalian

```
/project-root
│── index.php
│── db.php
│── save.php
│── fetch.php
│── get_one.php
│── delete.php
│── hash.php
│── typing.php
│── typing_status.php
│── get_last_id.php
│── setname.php
│── check_name.php
│── assets/
│      └── (tempatkan screenshot light dan dark mode di sini)
```

---

## ⚙️ Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/FatihAkmalH/highlight_recap.git
cd highlight_recap
```

### 2️⃣ Import Database  
Buat database MySQL:

```sql
CREATE DATABASE recapdb;
dapat diubah sesuai nama db yang diinginkan
```

Buat tabel recap:

```sql
CREATE TABLE recap (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE UNIQUE,
    notes TEXT,
    movie TEXT,
    sports TEXT,
    new_program TEXT,
    program_special TEXT,
    series TEXT,
    typing_user TEXT,
    typing_time DATETIME
);
```

### 3️⃣ Konfigurasi `db.php`
jika masih menggunakan localhost

```php
$host = "localhost";
$dbname = "recapdb";
$user = "root";
$pass = "";
```

### 4️⃣ Jalankan
Cukup buka di browser:

```
http://localhost/NAMA-PROJEK/
```

---

## 🌓 Dark Mode Support
Jika ingin mode gelap otomatis, tambahkan CSS berikut:

```css
@media (prefers-color-scheme: dark) {
    body {
        background: #1a1a1a;
        color: #eee;
    }
    .card-custom {
        background: #2b2b2bcc;
    }
}
```

---

## 🧪 API Endpoint

| File | Keterangan |
|------|------------|
| `save.php` | Simpan atau update recap |
| `fetch.php` | Generate recap formatted output |
| `get_one.php` | Ambil recap berdasarkan tanggal |
| `delete.php` | Hapus recap |
| `hash.php` | Hash untuk auto-refresh |
| `typing.php` | Kirim status typing |
| `typing_status.php` | Ambil status user yang mengetik |

---

## 🤝 Kontribusi
Pull request sangat diterima.  
Pastikan mengikuti struktur coding yang sudah ada.

---

## 📄 Lisensi
Proyek ini dirilis menggunakan lisensi **MIT License**.

---

## 📬 Kontak
Jika membutuhkan bantuan atau ingin menambahkan fitur baru:

**R&D Team MDTV – 2025**  
Email: `[Portofolio](https://portofolio-fatihakmal.netlify.app)`

---

## 🔗 Catatan
Untuk screenshot, letakkan di folder:

```
assets/screenshot-light.png
assets/screenshot-dark.png
```

Lalu ubah bagian berikut:

```md
![Light Mode](ADD_LINK_GAMBAR_LIGHT_MODE_DI_SINI)
![Dark Mode](ADD_LINK_GAMBAR_DARK_MODE_DI_SINI)
```

Menjadi:

```md
![Light Mode](assets/screenshot-light.png)
![Dark Mode](assets/screenshot-dark.png)
```

