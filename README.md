# Aplikasi Pendataan Betutu

# Admin
- Melihat laporan (Laporan)
- Menambah, mengubah, menghapus daftar menu dan harga (Daftar Menu)
- Melihat harga dan total harga pemesanan (Pesanan)
- Melihat menu dan harga (Daftar Menu)
- Memilih menu (Daftar Menu)
- Melihat total harga pesanan (Pesanan)
- Membuat pesanan (Pesanan)
- Update pesanan (Pesanan)
- Hapus Pesanan (Pesanan)

# fungsi code .htaccess
RewriteEngine On = Mengaktifkan modul mod_rewrite di Apache.Tanpa baris ini, aturan RewriteRule tidak akan berjalan
RewriteRule ^([a-zA-Z0-9]+)$ index.php?x=$1
RewriteRule ^([a-zA-Z0-9]+)/([0-9]+)$ index.php?x=$1&id=$2
kesimpulan :
^ = awal string
$ = akhir string
[a-zA-Z0-9]+ = grup
$1 = menangkap grup
