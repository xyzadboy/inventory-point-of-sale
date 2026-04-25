<p align="center"> <img src="dokumentasi/dashboard_user.png" width="500" alt="Inventory System Preview"> </p> <h1 align="center">📦 Inventory Management System</h1> <p align="center"> Sistem manajemen inventory berbasis web untuk pengelolaan stok, transaksi, dan data bisnis secara efisien. </p> <p align="center"> <img src="https://img.shields.io/badge/Laravel-10-red?style=for-the-badge&logo=laravel"> <img src="https://img.shields.io/badge/Filament-Admin%20Panel-blue?style=for-the-badge"> <img src="https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge"> <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge"> </p>
🚀 About Project

Inventory Management System merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan persediaan barang secara terstruktur dan terintegrasi. Sistem ini mendukung proses bisnis mulai dari pencatatan produk, pengelolaan stok, hingga transaksi dan pembuatan invoice.

Pendekatan yang digunakan adalah Role-Based Access Control (RBAC) untuk memastikan keamanan dan pembagian hak akses pengguna secara optimal.

✨ Key Features
📊 Dashboard monitoring real-time
📦 Manajemen produk & kategori
📏 Pengelolaan satuan barang
🏢 Data supplier
👥 Data customer
🧾 Transaksi order
🖨️ Cetak invoice otomatis
🔐 Role & Permission management (RBAC)
🖼️ System Preview
📊 Dashboard
<p align="center"> <img src="dokumentasi/dashboard_user.png" width="650"> </p> Menampilkan ringkasan data penting seperti jumlah produk, transaksi, supplier, dan customer sebagai pusat monitoring sistem.
📂 Kategori
<p align="center"> <img src="dokumentasi/Kategori.png" width="650"> </p> Digunakan untuk mengelompokkan produk agar pengelolaan lebih terstruktur dan sistematis.
📦 Produk
<p align="center"> <img src="dokumentasi/produk.png" width="650"> </p> Menampilkan data lengkap barang termasuk stok, harga, dan kategori sebagai inti dari sistem inventory.
📏 Satuan
<p align="center"> <img src="dokumentasi/satuan.png" width="650"> </p> Digunakan untuk mendefinisikan unit barang seperti pcs, box, liter, dan lainnya.
🏢 Supplier
<p align="center"> <img src="dokumentasi/supplier.png" width="650"> </p> Berisi data pemasok untuk mendukung proses pengadaan barang.
👥 Customer
<p align="center"> <img src="dokumentasi/customer.png" width="650"> </p> Menyimpan data pelanggan yang melakukan transaksi.
🧾 Order
<p align="center"> <img src="dokumentasi/order.png" width="650"> </p> Digunakan untuk mencatat transaksi pembelian atau pemesanan barang.
🖨️ Cetak Invoice
<p align="center"> <img src="dokumentasi/cetak_invoice.png" width="650"> </p> Menghasilkan invoice sebagai bukti transaksi yang dapat dicetak.
🔐 Roles
<p align="center"> <img src="dokumentasi/roles.png" width="650"> </p> Mengelola peran pengguna dalam sistem.
📝 Form Roles
<p align="center"> <img src="dokumentasi/roles_form.png" width="650"> </p> Digunakan untuk menambahkan atau mengedit role beserta hak aksesnya.
🔑 Permission
<p align="center"> <img src="dokumentasi/permission.png" width="650"> </p> Menampilkan daftar izin akses dalam sistem.
📝 Form Permission
<p align="center"> <img src="dokumentasi/permission_form.png" width="650"> </p> Digunakan untuk mengatur permission agar sistem lebih fleksibel dan aman.
🛠️ Tech Stack
⚙️ Laravel
🎛️ Filament Admin Panel
🗄️ MySQL
🎨 Tailwind CSS
⚙️ Installation
git clone https://github.com/username/nama-repo.git
cd nama-repo

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
📁 Project Structure
inventory/
└── dokumentasi/
    ├── cetak_invoice.png
    ├── customer.png
    ├── dashboard_user.png
    ├── Kategori.png
    ├── order.png
    ├── permission.png
    ├── permission_form.png
    ├── produk.png
    ├── roles.png
    ├── roles_form.png
    ├── satuan.png
    └── supplier.png
🎯 Project Goals
Meningkatkan efisiensi pengelolaan stok
Mengurangi kesalahan pencatatan manual
Menyediakan data real-time
Mendukung pengambilan keputusan berbasis data
🤝 Contributing

Kontribusi terbuka untuk pengembangan lebih lanjut. Silakan fork repository dan ajukan pull request.

📄 License

Project ini menggunakan lisensi MIT.
