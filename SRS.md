A. Deskripsi Umum
RuteSales adalah aplikasi pemantauan kunjungan sales lapangan ke toko/warung, dirancang untuk memenuhi standar proyek akademik/internal yang spesifik.
B. Kebutuhan Fungsional (Berdasarkan Standar Minimum)
- Fungsi Utama (Minimal 3 Modul CRUD Terkait): Sistem wajib memiliki fitur pengelolaan (CRUD) untuk data Sales (Pengguna), Toko, dan Rute Kunjungan.
- Alur Proses (Minimal 1 Alur Transaksi/Status): Sistem harus mencatat perubahan status kunjungan dari "Direncanakan" menjadi "Selesai (Berhasil/Tutup/Ditolak)" melalui formulir check-in.
- Formulir Kunjungan: Form check-in wajib mengimplementasikan validasi server-side, menampilkan pesan kesalahan jika input tidak sesuai, dan dilindungi oleh token CSRF. Form ini mencatat waktu, status, catatan, dan nilai pesanan (jika berhasil) atau alasan (jika gagal).
- URI Dinamis: Tersedia minimal 1 halaman detail rute (contoh: /rute/detail/{id}) yang merender data toko yang harus dikunjungi berdasarkan parameter ID pada URI.
- Dashboard (Minimal 2 Metrik): Halaman ringkasan untuk admin yang menampilkan metrik relevan: (1) Total Kunjungan Selesai, (2) Persentase Keberhasilan Kunjungan, dan (3) Total Nilai Pesanan.
- Data Awal & Pengujian: Sistem harus menyediakan data dummy untuk keperluan pengujian dan minimal 10 skenario pengujian (termasuk kasus input form yang tidak valid).
C. Batasan Fitur (Fitur Tidak Wajib)
- Lokasi (GPS/Geofencing): Pelacakan GPS real-time tidak diwajibkan; sistem cukup menggunakan data lokasi yang disimulasikan secara manual melalui form pencatatan oleh sales.