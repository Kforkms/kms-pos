# PRD — Aplikasi POS / Kasir Berbasis Web (MVP)

**Stack:** Laravel | **Timeline:** < 24 jam | **Versi:** 1.0 (MVP)

---

## 1. Executive Summary

Aplikasi POS web sederhana untuk mencatat transaksi kasir secara cepat dengan **auto-cut stok** saat transaksi berhasil. Pembayaran QRIS bersifat **statis & verifikasi manual** (tanpa payment gateway). Scope dibatasi ketat ke 3 modul inti agar bisa selesai dalam waktu kurang dari 24 jam: **Layar Kasir**, **Manajemen Produk/Stok**, dan **Laporan Transaksi**.

**Out of scope (eksplisit, jangan dikerjakan):**
- Integrasi payment gateway (Midtrans/Xendit/dll)
- Multi-cabang / multi-gudang
- Diskon, promo, voucher, member/loyalty
- Cetak struk fisik (print thermal)
- Multi-bahasa, multi-mata uang
- Approval/refund/void transaksi

---

## 2. User Roles & Access

| Role | Akses |
|---|---|
| **Admin/Owner** | Login → Dashboard Admin: CRUD produk, update stok manual, lihat & filter riwayat transaksi/laporan penjualan. **Tidak** mengoperasikan kasir sehari-hari (tapi tidak dibatasi jika perlu). |
| **Kasir** | Login → langsung ke **Halaman Kasir (POS)**. Hanya bisa memproses transaksi. **Tidak** punya akses ke manajemen produk atau laporan. |

**Auth:** Login sederhana (email/username + password), gunakan Laravel Breeze/Auth bawaan + middleware role (`admin`, `kasir`). Tidak perlu fitur register publik — user dibuat via seeder/admin.

---

## 3. User Flows

### 3.1 Flow Transaksi (Kasir) — Flow Utama
1. Kasir login → masuk ke **Halaman POS**.
2. Kasir memilih produk dari daftar menu (klik produk → masuk ke keranjang/cart).
3. Kasir mengatur jumlah (qty) per item di cart (+/-, atau input manual).
4. Sistem menampilkan subtotal & total otomatis secara real-time.
5. Kasir klik **"Checkout"**.
6. Sistem menampilkan modal/halaman pilihan metode pembayaran: **Cash** atau **QRIS**.
   - **Jika Cash:** Kasir input nominal uang diterima → sistem hitung kembalian otomatis.
   - **Jika QRIS:** Sistem menampilkan gambar QRIS statis (upload sekali oleh Admin) → kasir cek pembayaran masuk secara manual (di luar sistem, misal cek HP/EDC) → kasir input nominal yang dibayarkan.
7. Kasir klik **"Selesai / Bayar"**.
8. Sistem menyimpan transaksi (header + detail item) dan **otomatis memotong stok** masing-masing produk sesuai qty yang terjual.
9. Sistem menampilkan halaman/struk konfirmasi sukses (on-screen, tidak perlu print) → tombol "Transaksi Baru" untuk reset cart.

**Edge case wajib di-handle:**
- Stok produk tidak cukup → tombol checkout/tambah qty di-disable atau tampilkan warning, transaksi tidak bisa diproses melebihi stok tersedia.
- Nominal cash dibayar < total → tombol "Selesai" disabled, tampilkan pesan "Nominal kurang".
- Cart kosong → tombol checkout disabled.

### 3.2 Flow Manajemen Produk (Admin)
1. Admin login → masuk ke Dashboard Admin.
2. Menu **"Produk"** → lihat daftar produk (nama, kategori opsional, harga, stok).
3. **Tambah produk:** input nama, harga, stok awal, (foto opsional) → simpan.
4. **Edit produk:** ubah nama/harga/stok → simpan.
5. **Update stok manual:** input penambahan/pengurangan stok (misal restock) → stok terupdate.

### 3.3 Flow Laporan Transaksi (Admin)
1. Admin masuk ke menu **"Laporan / Riwayat Transaksi"**.
2. Sistem menampilkan list transaksi: tanggal/jam, kasir, metode bayar, total, status.
3. Admin bisa filter berdasarkan **rentang tanggal**.
4. Admin bisa klik 1 transaksi untuk lihat **detail item** yang dibeli.
5. *(Nice to have jika waktu cukup)* Total omzet harian ditampilkan sebagai summary di atas tabel.

---

## 4. Functional Requirements

### A. Modul Layar Kasir (POS Interface) — **Wajib**
- FR-1: Tampilkan daftar produk (grid/list) dengan nama, harga, gambar (opsional), dan indikator stok.
- FR-2: Kasir dapat menambah produk ke cart dengan 1 klik.
- FR-3: Kasir dapat mengubah qty item di cart (increment/decrement/input manual) dan menghapus item dari cart.
- FR-4: Sistem menghitung subtotal per item dan total keseluruhan secara real-time (tanpa reload).
- FR-5: Sistem validasi qty di cart tidak boleh melebihi stok yang tersedia.
- FR-6: Tombol Checkout membuka pilihan metode pembayaran: **Cash** / **QRIS**.
- FR-7: Untuk Cash — input nominal diterima, sistem hitung kembalian otomatis, validasi nominal ≥ total.
- FR-8: Untuk QRIS — tampilkan gambar QRIS statis (gambar di-set oleh Admin), kasir input nominal dibayar secara manual.
- FR-9: Tombol "Selesai/Bayar" menyimpan transaksi (header: tanggal, kasir, total, metode bayar, nominal bayar, kembalian; detail: produk, qty, harga satuan, subtotal).
- FR-10: Saat transaksi berhasil disimpan, sistem **otomatis mengurangi stok** tiap produk yang terjual (gunakan DB transaction agar simpan transaksi + potong stok bersifat atomic).
- FR-11: Tampilkan konfirmasi sukses on-screen setelah transaksi tersimpan, dengan opsi mulai transaksi baru (reset cart).

### B. Modul Manajemen Produk & Stok — **Wajib**
- FR-12: CRUD produk (Create, Read, Update; Delete opsional/soft-delete jika sempat) dengan field minimal: nama, harga jual, stok.
- FR-13: Form update stok manual (tambah/kurang) terpisah dari edit produk, untuk kebutuhan restock cepat.
- FR-14: Upload 1 gambar QRIS statis yang akan ditampilkan di layar kasir saat metode QRIS dipilih (disimpan sebagai setting/konfigurasi, bukan per transaksi).
- FR-15: Validasi input: harga & stok harus angka, tidak boleh negatif.

### C. Modul Laporan Transaksi / Histori Penjualan — **Wajib**
- FR-16: Tabel riwayat transaksi: tanggal, kasir, metode bayar, total, jumlah item.
- FR-17: Filter riwayat berdasarkan rentang tanggal (date range).
- FR-18: Detail transaksi (klik row) menampilkan daftar produk + qty + subtotal pada transaksi tersebut.

### D. Modul Auth & Role — **Wajib**
- FR-19: Login dengan email/username + password.
- FR-20: Middleware role: Kasir hanya bisa akses route POS; Admin bisa akses semua route (produk, laporan, dan opsional POS).
- FR-21: Logout.

---

## 5. Non-Functional Requirements

| Kategori | Requirement |
|---|---|
| **UI/UX — Tema Warna** | Halaman kasir (POS Interface) **wajib didominasi warna PINK** sesuai permintaan klien (primary color, button, header/navbar). Gunakan palet pink konsisten (misal: pink-500/600 sebagai primary, pink-100/50 sebagai background/aksen) — bisa via Tailwind CSS custom theme. Halaman Admin (produk/laporan) boleh netral, tidak wajib pink. |
| **Layout** | Sederhana, intuitif, satu halaman utama untuk kasir (tanpa banyak navigasi/klik), mengikuti wireframe yang sudah disiapkan tim internal. |
| **Responsiveness** | Wajib responsif minimal untuk **tablet/desktop landscape** (target device meja kasir). Mobile-friendly jadi nilai tambah, bukan prioritas utama. |
| **Performa** | Aksi tambah ke cart, hitung total, dan checkout harus terasa instan (gunakan AJAX/Livewire/Alpine.js, hindari full page reload pada flow kasir). |
| **Data Integrity** | Penyimpanan transaksi dan pemotongan stok harus dalam satu **DB Transaction** (Laravel `DB::transaction()`) agar tidak terjadi data tidak konsisten (transaksi tersimpan tapi stok tidak terpotong, atau sebaliknya). |
| **Keamanan dasar** | Password di-hash (default Laravel), route POS/Admin dilindungi middleware auth + role, CSRF protection aktif (default Laravel). |
| **Browser Support** | Chrome/Edge versi terbaru (cukup untuk kebutuhan internal kasir). |
| **Deployment** | Cukup 1 environment (tanpa staging terpisah) mengingat timeline ketat; gunakan SQLite/MySQL sesuai yang tersedia tercepat untuk setup. |

---

## 6. Rekomendasi Teknis Singkat (untuk Tim Dev)

- **Stack realtime cart:** Livewire atau Alpine.js + AJAX — hindari Vue/React penuh kecuali tim sudah familiar, demi kecepatan.
- **Struktur tabel minimal:** `users` (+role), `products` (name, price, stock), `transactions` (header), `transaction_items` (detail), `settings` (untuk path gambar QRIS statis).
- **Prioritas eksekusi (urutan kerja yang disarankan):**
  1. Setup auth + role + migration & seeder dasar.
  2. Modul Produk (CRUD) — paling sederhana, kerjakan duluan agar data tersedia untuk testing POS.
  3. Modul POS (cart + checkout + auto-cut stok) — **core fokus utama, paling kompleks**.
  4. Modul Laporan Transaksi.
  5. Styling tema pink + responsivitas — terakhir, setelah fungsi inti berjalan.

---

*Dokumen ini bersifat final untuk scope MVP. Setiap penambahan fitur di luar daftar Functional Requirements di atas dianggap out-of-scope untuk rilis pertama dan perlu dijadwalkan di iterasi berikutnya.*
