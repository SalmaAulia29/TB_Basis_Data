

CREATE TABLE toko (
    id_toko INT PRIMARY KEY AUTO_INCREMENT,
    nama_toko VARCHAR(100) NOT NULL,
    telepon VARCHAR(20),
    email VARCHAR(100)
);

CREATE TABLE pelanggan (
    id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
    nama_pelanggan VARCHAR(100) NOT NULL,
    telepon VARCHAR(20)
);

CREATE TABLE kategori_produk (
    id_kategori INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(50) NOT NULL,
    durasi_garansi VARCHAR(50)
);

CREATE TABLE produk (
    id_produk INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(100) NOT NULL,
    id_kategori INT,
    harga DECIMAL(15,2),
    FOREIGN KEY (id_kategori) REFERENCES kategori_produk(id_kategori)
);

CREATE TABLE rekening_pembayaran (
    id_rekening INT PRIMARY KEY AUTO_INCREMENT,
    bank VARCHAR(50),
    nama_penerima VARCHAR(100),
    no_rekening VARCHAR(50)
);

CREATE TABLE karyawan (
    id_karyawan INT PRIMARY KEY AUTO_INCREMENT,
    nama_karyawan VARCHAR(50),
    posisi VARCHAR(50)
);

CREATE TABLE kebijakan (
    id_kebijakan INT PRIMARY KEY AUTO_INCREMENT,
    nama_kebijakan VARCHAR(50),
    deskripsi TEXT
);

CREATE TABLE transaksi (
    id_transaksi INT PRIMARY KEY AUTO_INCREMENT,
    id_toko INT,
    id_pelanggan INT,
    id_produk INT,
    id_rekening INT,
    id_karyawan INT,
    id_kebijakan INT,
    tanggal DATE,
    banyaknya INT,
    total DECIMAL(15,2),
    FOREIGN KEY (id_toko) REFERENCES toko(id_toko),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk),
    FOREIGN KEY (id_rekening) REFERENCES rekening_pembayaran(id_rekening),
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id_karyawan),
    FOREIGN KEY (id_kebijakan) REFERENCES kebijakan(id_kebijakan)
);
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
INSERT INTO admin (username, password) VALUES (
    'admin',
    'admin'
);


-- Insert data awal
INSERT INTO toko (nama_toko, telepon, email) VALUES 
('TOKAGADGET', '+62 896-5009-0645', 'tokagadget@gmail.com');
INSERT INTO kategori_produk (nama_kategori, durasi_garansi) VALUES
('inter', '3 Bulan'),
('iBox', '1 Tahun'),
('Sein', '1 Tahun');

INSERT INTO produk (nama_produk, id_kategori, harga) VALUES 
('iPhone 11 64GB', 2, 300000.00),
('iPhone 12 64GB', 2, 500000.00),
('Samsung Galaxy A54', 1, 250000.00),
('iPhone 13 128GB', 3, 700000.00);

INSERT INTO rekening_pembayaran (bank, nama_penerima, no_rekening) VALUES 
('Bank BCA', 'Raka Maulidz', '1481028472');

INSERT INTO karyawan (nama_karyawan, posisi) VALUES 
('Dina', 'Kasir'),
('Raka Maulidz', 'Kasir');

INSERT INTO kebijakan (nama_kebijakan, deskripsi) VALUES 
('refund', 'tidak bisa refund');