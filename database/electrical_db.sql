-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Bulan Mei 2018 pada 11.59
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electrical_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_barang`
--

CREATE TABLE `ms_barang` (
  `kode_barang` char(7) NOT NULL,
  `kode_barcode` varchar(40) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `ukuran_barang` varchar(30) NOT NULL,
  `kode_kategori` char(4) NOT NULL,
  `kode_satuan` char(4) NOT NULL,
  `kode_merk` char(4) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `stok_barang` int(6) NOT NULL,
  `keterangan_barang` text NOT NULL,
  `status_barang` enum('Active','Non Active') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_barang`
--

INSERT INTO `ms_barang` (`kode_barang`, `kode_barcode`, `nama_barang`, `ukuran_barang`, `kode_kategori`, `kode_satuan`, `kode_merk`, `harga_jual`, `harga_beli`, `stok_barang`, `keterangan_barang`, `status_barang`) VALUES
('B00001', 'ZE0001         ', 'BOX MCB 4 GROUP TUTUP PUTIH BROCO 17104-55        ', '-    ', 'K001', 'S001', 'M001', 0, 0, 0, '-', 'Active'),
('B00002', 'ZE0002         ', 'BOX MCB 8 GROUP TUTUP PUTIH BROCO 17108-55        ', '                              ', 'K001', 'S001', 'M001', 0, 0, 0, '', 'Active'),
('B00003', 'ZE0003         ', 'MCB 1P/2A BROCO 17302C                            ', '                              ', 'K001', 'S001', 'M001', 32100, 28973, 0, '', 'Active'),
('B00004', 'ZE0004         ', 'MCB 1P/4A BROCO 17304C                            ', '                              ', 'K001', 'S001', 'M001', 29552, 28973, 0, '', 'Active'),
('B00005', 'ZE0005         ', 'MCB 1P/6A BROCO 17306C                            ', '                              ', 'K001', 'S001', 'M001', 34172, 28477, 0, '', 'Active'),
('B00006', 'ZE0174         ', 'NYA 1X1.5 MM2 KUNING SUTRADO                      ', '-                       ', 'K001', 'Acti', 'M002', 1800, 1513, 0, '', 'Active'),
('B00007', 'ZE0006         ', 'MCB 1P/10A BROCO 17310C                           ', '                              ', 'K001', 'S001', 'M001', 29750, 28477, 0, '', 'Active'),
('B00008', 'ZE0007         ', 'MCB 1P/16A BROCO 17316C                           ', '                              ', 'K001', 'S001', 'M001', 31600, 28477, 0, '', 'Active'),
('B00009', 'ZE0101         ', 'MCB 1P/20A BROCO 17320C                           ', '                              ', 'K001', 'S001', 'M001', 30294, 29700, 0, '', 'Active'),
('B00010', 'ZE0102         ', 'MCB 1P/25A BROCO 17325C                           ', '                              ', 'K001', 'S001', 'M001', 34000, 29700, 0, '', 'Active'),
('B00011', 'ZE0103         ', 'MCB 1P/32A BROCO 17332C                           ', '                              ', 'K001', 'S001', 'M001', 34000, 32130, 0, '', 'Active'),
('B00012', 'ZE0008         ', 'NYA 1X1.5 MM2 MERAH SUTRADO                       ', '                              ', 'K001', 'S002', 'M002', 1800, 1513, 0, '', 'Active'),
('B00013', 'ZE0009         ', 'NYA 1X1.5 MM2 MERAH PULUNG                        ', '                              ', 'K001', 'S002', 'M004', 0, 1443, 0, '', 'Active'),
('B00014', 'ZE0010         ', 'MCB DOMAE 1P/25A SCHNEIDER DOM11344SNI            ', '                              ', 'K001', 'S001', 'M003', 46000, 45628, 0, '', 'Active'),
('B00015', 'ZE0011         ', 'MCB DOMAE 1P/16A SCHNEIDER DOM11342SNI            ', '                              ', 'K001', 'S001', 'M003', 41200, 40392, 0, '', 'Active'),
('B00016', 'ZE0012         ', 'NYA 1X1.5 MM2 KUNING PULUNG                       ', '                              ', 'K001', 'S002', 'M004', 0, 1443, 0, '', 'Active'),
('B00017', 'ZE0013         ', 'MCB DOMAE 1P/6A SCHNEIDER DOM11340SNI             ', '                              ', 'K001', 'S001', 'M003', 48470, 40392, 0, '', 'Active'),
('B00018', 'ZE0014         ', 'ELCB DOMAE 4P/63A 300MA SCHNEIDER DOM16796        ', '                              ', 'K001', 'S001', 'M003', 653845, 641025, 0, '', 'Active'),
('B00019', 'ZE0015         ', 'NYA 1X1.5 MM2 Y/G SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 1800, 1513, 0, '', 'Active'),
('B00020', 'ZE0016         ', 'NYA 1X1.5 MM2 Y/G PULUNG                          ', '                              ', 'K001', 'S002', 'M004', 0, 1443, 0, '', 'Active'),
('B00021', 'ZE0017         ', 'KONTAKTOR AC 3P/95A 220V SCHNEIDER LC1D95M7       ', '                              ', 'K001', 'S001', 'M003', 1667404, 1634710, 0, '', 'Active'),
('B00022', 'ZE0018         ', 'BOX MCB DOMAE IB 4 GROUP SCHNEIDER DOMH12104F     ', '                              ', 'K001', 'S001', 'M003', 59325, 58162, 0, '', 'Active'),
('B00023', 'ZE0019         ', 'NYA 1X1.5 MM2 BIRU SUTRADO                        ', '                              ', 'K001', 'S002', 'M002', 1800, 1513, 0, '', 'Active'),
('B00024', 'ZE0020         ', 'NYA 1X1.5 MM2 BIRU PULUNG                         ', '                              ', 'K001', 'S002', 'M004', 0, 1443, 0, '', 'Active'),
('B00025', 'ZE0021         ', 'MATA BOR D500 10.5MM NACHI                        ', '                              ', 'K001', 'S001', 'M005', 101850, 99854, 0, '', 'Active'),
('B00026', 'ZE0022         ', 'WALL BOX SCHNEIDER SWB 727245                     ', '                              ', 'K001', 'S001', 'M003', 2500, 2310, 0, '', 'Active'),
('B00027', 'ZE0023         ', 'MATA BOR D500 9MM NACHI                           ', '                              ', 'K001', 'S001', 'M005', 67654, 66328, 0, '', 'Active'),
('B00028', 'ZE0024         ', 'MATA BOR D500 8MM NACHI                           ', '                              ', 'K001', 'S001', 'M005', 52229, 51205, 0, '', 'Active'),
('B00029', 'ZE0025         ', 'NYA 1X1.5 MM2 HITAM SUTRADO                       ', '                              ', 'K001', 'S002', 'M002', 1800, 1513, 0, '', 'Active'),
('B00030', 'ZE0026         ', 'NYA 1X1.5 MM2 HITAM PULUNG                        ', '                              ', 'K001', 'S002', 'M004', 0, 1443, 0, '', 'Active'),
('B00031', 'ZE0027         ', 'NYA 1X2.5 MM2 MERAH SUTRADO                       ', '                              ', 'K001', 'S002', 'M002', 2800, 2444, 0, '', 'Active'),
('B00032', 'ZE0028         ', 'NYA 1X2.5 MM2 MERAH PULUNG                        ', '                              ', 'K001', 'S002', 'M004', 0, 2374, 0, '', 'Active'),
('B00033', 'ZE0029         ', 'MATA BOR D500 6.5MM NACHI                         ', '                              ', 'K001', 'S001', 'M005', 37793, 37052, 0, '', 'Active'),
('B00034', 'ZE0030         ', 'MATA BOR D500 5.5MM NACHI                         ', '                              ', 'K001', 'S001', 'M005', 28824, 28259, 0, '', 'Active'),
('B00035', 'ZE0031         ', 'NYA 1X2.5 MM2 KUNING SUTRADO                      ', '                              ', 'K001', 'S002', 'M002', 2800, 2444, 0, '', 'Active'),
('B00036', 'ZE0032         ', 'NYA 1X2.5 MM2 KUNING PULUNG                       ', '                              ', 'K001', 'S002', 'M004', 0, 2374, 0, '', 'Active'),
('B00037', 'ZE0033         ', 'MATA BOR D500 4.5MM NACHI                         ', '                              ', 'K001', 'S001', 'M005', 21551, 21129, 0, '', 'Active'),
('B00038', 'ZE0034         ', 'CARBON BRUSH CB-203A MAKITA B-80341               ', '                              ', 'K001', 'S001', 'M006', 39000, 38250, 0, '', 'Active'),
('B00039', 'ZE0035         ', 'NYA 1X2.5 MM2 Y/G SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 2800, 2444, 0, '', 'Active'),
('B00040', 'ZE0036         ', 'NYA 1X2.5 MM2 Y/G PULUNG                          ', '                              ', 'K001', 'S002', 'M004', 0, 2374, 0, '', 'Active'),
('B00041', 'ZE0037         ', 'MATA BOR D500 1.5MM NACHI                         ', '                              ', 'K001', 'S001', 'M005', 13870, 13598, 0, '', 'Active'),
('B00042', 'ZE0038         ', 'BATU FLEXIBLE 4\" MAKITA A-85139                   ', '                              ', 'K001', 'S001', 'M006', 11000, 10625, 0, '', 'Active'),
('B00043', 'ZE0039         ', 'NYA 1X2.5 MM2 BIRU SUTRADO                        ', '                              ', 'K001', 'S002', 'M002', 2800, 2444, 0, '', 'Active'),
('B00044', 'ZE0040         ', 'NYA 1X2.5 MM2 BIRU PULUNG                         ', '                              ', 'K001', 'S002', 'M004', 0, 2374, 0, '', 'Active'),
('B00045', 'ZE0041         ', 'BATU POTONG MAKITA A-89545-25                     ', '                              ', 'K001', 'S001', 'M006', 55000, 46750, 0, '', 'Active'),
('B00046', 'ZE0042         ', 'BATU POTONG MAKITA A-85329                        ', '                              ', 'K001', 'S001', 'M006', 23000, 22100, 0, '', 'Active'),
('B00047', 'ZE0043         ', 'NYA 1X2.5 MM2 HITAM SUTRADO                       ', '                              ', 'K001', 'S002', 'M002', 2800, 2444, 0, '', 'Active'),
('B00048', 'ZE0044         ', 'NYA 1X2.5 MM2 HITAM PULUNG                        ', '                              ', 'K001', 'S002', 'M004', 0, 2374, 0, '', 'Active'),
('B00049', 'ZE0045         ', 'BATU POTONG MAKITA A-85123                        ', '                              ', 'K001', 'S001', 'M006', 9103, 8925, 0, '', 'Active'),
('B00050', 'ZE0046         ', 'BATU POLES 7X6 MAKITA A-80949                     ', '                              ', 'K001', 'S001', 'M006', 26010, 25500, 0, '', 'Active'),
('B00051', 'ZE0047         ', 'NYA 1X4 MM2 MERAH SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 4700, 4376, 0, '', 'Active'),
('B00052', 'ZE0048         ', 'NYA 1X4 MM2 MERAH PULUNG                          ', '                              ', 'K001', 'S002', 'M004', 0, 4230, 0, '', 'Active'),
('B00053', 'ZE0049         ', 'BATU POLES 5X6 MAKITA A-80933                     ', '                              ', 'K001', 'S001', 'M006', 17340, 17000, 0, '', 'Active'),
('B00054', 'ZE0050         ', 'BATU POLES 4X6 MAKITA A-87719                     ', '                              ', 'K001', 'S001', 'M006', 10404, 10200, 0, '', 'Active'),
('B00055', 'ZE0051         ', 'NYA 1X4 MM2 KUNING SUTRADO                        ', '                              ', 'K001', 'S002', 'M002', 4700, 4376, 0, '', 'Active'),
('B00056', 'ZE0052         ', 'NYA 1X4 MM2 KUNING PULUNG                         ', '                              ', 'K001', 'S002', 'M004', 0, 4230, 0, '', 'Active'),
('B00057', 'ZE0053         ', 'CARBON BRUSH CB-64A MAKITA B-80254                ', '                              ', 'K001', 'S001', 'M006', 21675, 21250, 0, '', 'Active'),
('B00058', 'ZE0054         ', 'CARBON BRUSH CB-419A MAKITA B-80422               ', '                              ', 'K001', 'S001', 'M006', 30000, 29750, 0, '', 'Active'),
('B00059', 'ZE0055         ', 'NYA 1X4 MM2 Y/G SUTRADO                           ', '                              ', 'K001', 'S002', 'M002', 4700, 4376, 0, '', 'Active'),
('B00060', 'ZE0056         ', 'NYA 1X4 MM2 Y/G PULUNG                            ', '                              ', 'K001', 'S002', 'M004', 0, 4230, 0, '', 'Active'),
('B00061', 'ZE0057         ', 'CARBON BRUSH CB-100A MAKITA B-80298               ', '                              ', 'K001', 'S001', 'M006', 26010, 25500, 0, '', 'Active'),
('B00062', 'ZE0058         ', 'CARBON BRUSH 153A MAKITA B-80329                  ', '                              ', 'K001', 'S001', 'M006', 26010, 25500, 0, '', 'Active'),
('B00063', 'ZE0059         ', 'NYA 1X4 MM2 BIRU SUTRADO                          ', '                              ', 'K001', 'S002', 'M002', 4700, 4376, 0, '', 'Active'),
('B00064', 'ZE0060         ', 'NYA 1X4 MM2 BIRU PULUNG                           ', '                              ', 'K001', 'S002', 'M004', 0, 4230, 0, '', 'Active'),
('B00065', 'ZE0061         ', 'PNEUMATIC AIR NAILER MAKITA AF301Z                ', '                              ', 'K001', 'S001', 'M006', 612000, 600000, 0, '', 'Active'),
('B00066', 'ZE0062         ', 'MESIN SERUT LISTRIK N1900B MAKITA                 ', '                              ', 'K001', 'S001', 'M006', 2142000, 2100000, 0, '', 'Active'),
('B00067', 'ZE0063         ', 'NYA 1X4 MM2 HITAM SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 4700, 4376, 0, '', 'Active'),
('B00068', 'ZE0064         ', 'NYA 1X4 MM2 HITAM PULUNG                          ', '                              ', 'K001', 'S002', 'M004', 0, 4230, 0, '', 'Active'),
('B00069', 'ZE0065         ', 'MESIN PROFIL N3701 MAKITA                         ', '                              ', 'K001', 'S001', 'M006', 1590000, 1550000, 0, '', 'Active'),
('B00070', 'ZE0066         ', 'MESIN PROFIL MAKITA 3709                          ', '                              ', 'K001', 'S001', 'M006', 892500, 875000, 0, '', 'Active'),
('B00071', 'ZE0067         ', 'NYA 1X6 MM2 MERAH SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 7260, 6418, 0, '', 'Active'),
('B00072', 'ZE0068         ', 'NYA 1X6 MM2 MERAH PULUNG                          ', '                              ', 'K001', 'S002', 'M004', 0, 6321, 0, '', 'Active'),
('B00073', 'ZE0069         ', 'SANDER POLISHER 180MM MAKITA 9207SPB              ', '                              ', 'K001', 'S001', 'M006', 3835000, 3600000, 0, '', 'Active'),
('B00074', 'ZE0070         ', 'MESIN POLES MOBIL 7\" GV7000 MAKITA                ', '                              ', 'K001', 'S001', 'M006', 3400000, 3350000, 0, '', 'Active'),
('B00075', 'ZE0071         ', 'NYA 1X6 MM2 KUNING SUTRADO                        ', '                              ', 'K001', 'S002', 'M002', 7260, 6418, 0, '', 'Active'),
('B00076', 'ZE0072         ', 'NYA 1X6 MM2 KUNING PULUNG                         ', '                              ', 'K001', 'S002', 'M004', 0, 6321, 0, '', 'Active'),
('B00077', 'ZE0073         ', 'MESIN GURINDA TANGAN 6\" 9006N MAKITA              ', '                              ', 'K001', 'S001', 'M006', 2652000, 2600000, 0, '', 'Active'),
('B00078', 'ZE0074         ', 'MESIN GURINDA TANGAN 5\" 9005N MAKITA              ', '                              ', 'K001', 'S001', 'M006', 2601000, 2550000, 0, '', 'Active'),
('B00079', 'ZE0075         ', 'NYA 1X6 MM2 Y/G SUTRADO                           ', '                              ', 'K001', 'S002', 'M002', 7260, 6418, 0, '', 'Active'),
('B00080', 'ZE0076         ', 'NYA 1X6 MM2 Y/G PULUNG                            ', '                              ', 'K001', 'S002', 'M004', 0, 6321, 0, '', 'Active'),
('B00081', 'ZE0077         ', 'MESIN GURINDA TANGAN 4\" GA4034 MAKITA             ', '                              ', 'K001', 'S001', 'M006', 969000, 950000, 0, '', 'Active'),
('B00082', 'ZE0078         ', 'MESIN GURINDA TANGAN 4\" GA4030 SLIM BODY MAKITA   ', '                              ', 'K001', 'S001', 'M006', 663000, 650000, 0, '', 'Active'),
('B00083', 'ZE0079         ', 'NYA 1X6 MM2 BIRU SUTRADO                          ', '                              ', 'K001', 'S002', 'M002', 7260, 6418, 0, '', 'Active'),
('B00084', 'ZE0080         ', 'NYA 1X6 MM2 BIRU PULUNG                           ', '                              ', 'K001', 'S002', 'M004', 0, 6321, 0, '', 'Active'),
('B00085', 'ZE0081         ', 'MESIN GURINDA MULTI FUNGSI TM3000C MAKITA         ', '                              ', 'K001', 'S001', 'M006', 3060000, 3000000, 0, '', 'Active'),
('B00086', 'ZE0082         ', 'MESIN BOR TANGAN 6301 MAKITA                      ', '                              ', 'K001', 'S001', 'M006', 2703000, 2650000, 0, '', 'Active'),
('B00087', 'ZE0083         ', 'NYA 1X6 MM2 HITAM SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 7260, 6418, 0, '', 'Active'),
('B00088', 'ZE0084         ', 'NYA 1X6 MM2 HITAM PULUNG                          ', '                              ', 'K001', 'S002', 'M004', 0, 6321, 0, '', 'Active'),
('B00089', 'ZE0085         ', 'MESIN BOR LCT204 MAKITA                           ', '                              ', 'K001', 'S001', 'M006', 2610000, 2550000, 0, '', 'Active'),
('B00090', 'ZE0086         ', 'MESIN BOR HR2460 MAKITA                           ', '                              ', 'K001', 'S001', 'M006', 1734000, 1700000, 0, '', 'Active'),
('B00091', 'ZE0087         ', 'NYM 2X1.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 5700, 5074, 0, '', 'Active'),
('B00092', 'ZE0088         ', 'NYM 2X1.5 MM2 PULUNG                              ', '                              ', 'K001', 'S002', 'M004', 0, 4934, 0, '', 'Active'),
('B00093', 'ZE0089         ', 'MESIN BOR HR2230-X5 MAKITA                        ', '                              ', 'K001', 'S001', 'M006', 1657500, 1625000, 0, '', 'Active'),
('B00094', 'ZE0090         ', 'MESIN BOR HR2230 MAKITA                           ', '                              ', 'K001', 'S001', 'M006', 1657500, 1625000, 0, '', 'Active'),
('B00095', 'ZE0091         ', 'NYM 2X2.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 7950, 7215, 0, '', 'Active'),
('B00096', 'ZE0092         ', 'NYM 2X2.5 MM2 PULUNG                              ', '                              ', 'K001', 'S002', 'M004', 0, 7169, 0, '', 'Active'),
('B00097', 'ZE0093         ', 'MESIN BOR DS4011 MAKITA                           ', '                              ', 'K001', 'S001', 'M006', 3825000, 3750000, 0, '', 'Active'),
('B00098', 'ZE0094         ', 'MESIN BOR DF330D MAKITA                           ', '                              ', 'K001', 'S001', 'M006', 918000, 900000, 0, '', 'Active'),
('B00099', 'ZE0095         ', 'NYY 2X1.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 7500, 6516, 0, '', 'Active'),
('B00100', 'ZE0104         ', 'MCB 1P/40A BROCO 17340C                           ', '                              ', 'K001', 'S001', 'M001', 38556, 32130, 0, '', 'Active'),
('B00101', 'ZE0105         ', 'KLEM PIPA 20MM CLIPSAL PUTIH                      ', '                              ', 'K001', 'S001', 'M007', 580, 550, 0, '', 'Active'),
('B00102', 'ZE0106         ', 'SOK PIPA 20MM CLIPSAL PUTIH                       ', '20 MM                         ', 'K001', 'S001', 'M007', 575, 550, 0, '', 'Active'),
('B00103', 'ZE0107         ', 'T-DUS CBG3 20MM CLIPSAL PUTIH                     ', '20 MM                         ', 'K001', 'S001', 'M007', 5000, 4550, 0, '', 'Active'),
('B00104', 'ZE0108         ', 'T-DUS CBG4 20MM CLIPSAL PUTIH                     ', '20 MM                         ', 'K001', 'S001', 'M007', 5000, 4550, 0, '', 'Active'),
('B00105', 'ZE0109         ', 'NYAF 1X1.5 ETERNA HITAM                           ', '                              ', 'K001', 'S002', 'M008', 2500, 2115, 0, '', 'Active'),
('B00106', 'ZE0110         ', 'NYAF 1X1.5 ETERNA Y/G                             ', '                              ', 'K001', 'S002', 'M008', 2500, 2115, 0, '', 'Active'),
('B00107', 'ZE0111         ', 'NYAF 1X1.5 ETERNA MERAH                           ', '                              ', 'K001', 'S002', 'M008', 2500, 2115, 0, '', 'Active'),
('B00108', 'ZE0112         ', 'NYAF 1X6 ETERNA MERAH                             ', '                              ', 'K001', 'S002', 'M008', 9000, 8121, 0, '', 'Active'),
('B00109', 'ZE0113         ', 'NYAF 1X4 ETERNA HITAM                             ', '                              ', 'K001', 'S002', 'M008', 7500, 5443, 0, '', 'Active'),
('B00110', 'ZE0096         ', 'NYY 2X1.5 MM2 PULUNG                              ', '                              ', 'K001', 'S002', 'M004', 0, 6418, 0, '', 'Active'),
('B00111', 'ZE0114         ', 'NYAF 1X35 ETERNA MERAH                            ', '                              ', 'K001', 'S002', 'M008', 43758, 42901, 0, '', 'Active'),
('B00112', 'ZE0115         ', 'NYMHY 2X0.75 ETERNA                               ', '                              ', 'K001', 'S002', 'M008', 4030, 3951, 0, '', 'Active'),
('B00113', 'ZE0116         ', 'MCB DOMAE 1P/40A SCHNEIDER DOM11346SNI            ', '                              ', 'K001', 'S001', 'M003', 55315, 54230, 0, '', 'Active'),
('B00114', 'ZE0117         ', 'NYMHY 2X1.5 ETERNA                                ', '                              ', 'K001', 'S002', 'M008', 6909, 6774, 0, '', 'Active'),
('B00115', 'ZE0118         ', 'NYMHY 2X2.5 ETERNA                                ', '                              ', 'K001', 'S002', 'M008', 9356, 9173, 0, '', 'Active'),
('B00116', 'ZE0119         ', 'NYMHY 3X0.75 ETERNA                               ', '                              ', 'K001', 'S002', 'M008', 8500, 6350, 0, '', 'Active'),
('B00117', 'ZE0120         ', 'NYMHY 3X1.5 ETERNA                                ', '                              ', 'K001', 'S002', 'M008', 9536, 9349, 0, '', 'Active'),
('B00118', 'ZE0121         ', 'NYYHY 2X2.5 ETERNA                                ', '                              ', 'K001', 'S002', 'M008', 9356, 9173, 0, '', 'Active'),
('B00119', 'ZE0122         ', 'NYA 1X1.5 ETERNA BIRU                             ', '                              ', 'K001', 'S002', 'M008', 1899, 1810, 0, '', 'Active'),
('B00120', 'ZE0123         ', 'NYA 1X1.5 ETERNA HITAM                            ', '                              ', 'K001', 'S002', 'M008', 1899, 1810, 0, '', 'Active'),
('B00121', 'ZE0097         ', 'NYY 2X2.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 12000, 9044, 0, '', 'Active'),
('B00122', 'ZE0124         ', 'NYA 1X1.5 ETERNA Y/G                              ', '                              ', 'K001', 'S002', 'M008', 1899, 1810, 0, '', 'Active'),
('B00123', 'ZE0125         ', 'NYA 1X1.5 ETERNA MERAH                            ', '                              ', 'K001', 'S002', 'M008', 1899, 1810, 0, '', 'Active'),
('B00124', 'ZE0126         ', 'NYA 1X2.5 ETERNA BIRU                             ', '                              ', 'K001', 'S002', 'M008', 3070, 2896, 0, '', 'Active'),
('B00125', 'ZE0127         ', 'NYA 1X2.5 ETERNA HITAM                            ', '                              ', 'K001', 'S002', 'M008', 3070, 2896, 0, '', 'Active'),
('B00126', 'ZE0128         ', 'NYA 1X2.5 ETERNA Y/G                              ', '                              ', 'K001', 'S002', 'M008', 3070, 2896, 0, '', 'Active'),
('B00127', 'ZE0129         ', 'NYA 1X2.5 ETERNA MERAH                            ', '                              ', 'K001', 'S002', 'M008', 3070, 2896, 0, '', 'Active'),
('B00128', 'ZE0130         ', 'NYA 1X4 ETERNA Y/G                                ', '                              ', 'K001', 'S002', 'M008', 4615, 4525, 0, '', 'Active'),
('B00129', 'ZE0131         ', 'NYM 2X1.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 5901, 5786, 0, '', 'Active'),
('B00130', 'ZE0132         ', 'NYM 2X2.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 8463, 8298, 0, '', 'Active'),
('B00131', 'ZE0133         ', 'NYM 3X1.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 7571, 7423, 0, '', 'Active'),
('B00132', 'ZE0098         ', 'NYY 2X2.5 MM2 PULUNG                              ', '                              ', 'K001', 'S002', 'M004', 0, 8801, 0, '', 'Active'),
('B00133', 'ZE0134         ', 'NYM 3X2.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 10796, 10584, 0, '', 'Active'),
('B00134', 'ZE0135         ', 'NYM 3X4 ETERNA                                    ', '                              ', 'K001', 'S002', 'M008', 17179, 16843, 0, '', 'Active'),
('B00135', 'ZE0136         ', 'NYM 4X4 ETERNA                                    ', '                              ', 'K001', 'S002', 'M008', 22127, 21694, 0, '', 'Active'),
('B00136', 'ZE0137         ', 'NYY 2X1.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 8900, 8185, 0, '', 'Active'),
('B00137', 'ZE0138         ', 'NYY 2X2.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 12500, 11007, 0, '', 'Active'),
('B00138', 'ZE0139         ', 'NYY 3X1.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 10292, 10090, 0, '', 'Active'),
('B00139', 'ZE0140         ', 'NYY 3X2.5 ETERNA                                  ', '                              ', 'K001', 'S002', 'M008', 17000, 13548, 0, '', 'Active'),
('B00140', 'ZE0141         ', 'SOK PIPA 20MM LEGRAND PUTIH SC20                  ', '20 MM                         ', 'K001', 'S001', 'M009', 500, 450, 0, '', 'Active'),
('B00141', 'ZE0142         ', 'T-DUS CBG3 20MM LEGRAND PUTIH SCB20-3N            ', '20 MM                         ', 'K001', 'S001', 'M009', 3600, 3000, 0, '', 'Active'),
('B00142', 'ZE0143         ', 'TUTUP T-DUS CBG3 20MM LEGRAND PUTIH SPC           ', '20 MM                         ', 'K001', 'S001', 'M009', 1020, 1000, 0, '', 'Active'),
('B00143', 'ZE0099         ', 'NYY 3X1.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 9500, 8169, 0, '', 'Active'),
('B00144', 'ZE0144         ', 'BATTERY BL1013 SET TD090D MAKITA                  ', '                              ', 'K001', 'S001', 'M006', 349000, 297500, 0, '', 'Active'),
('B00145', 'ZE0145         ', 'BATTERY CHARGER DC10WA MAKITA 194588-1            ', '                              ', 'K001', 'S001', 'M006', 382500, 382500, 5, '', 'Active'),
('B00146', 'ZE0146         ', 'HEAT GUN MAKITA HG-6500                           ', '                              ', 'K001', 'S001', 'M006', 969000, 950000, 0, '', 'Active'),
('B00147', 'ZE0147         ', 'HEAVY DUTY AIR TACKER 10MM MAKITA AT1022AZ        ', '                              ', 'K001', 'S001', 'M006', 637500, 625000, 0, '', 'Active'),
('B00148', 'ZE0148         ', 'MESIN AMPLAS BO3700 MAKITA                        ', '                              ', 'K001', 'S001', 'M006', 816000, 800000, 0, '', 'Active'),
('B00149', 'ZE0149         ', 'MESIN BOR BETON 13MM NHP1300S MAKITA              ', '                              ', 'K001', 'S001', 'M006', 2295000, 2250000, 0, '', 'Active'),
('B00150', 'ZE0150         ', 'MESIN BOR BETON 16MM HP1630 MAKITA                ', '                              ', 'K001', 'S001', 'M006', 841500, 825000, 0, '', 'Active'),
('B00151', 'ZE0151         ', 'NYY 4X4 MM2 SUTRADO                               ', '                              ', 'K001', 'S002', 'M002', 25000, 22367, 0, '', 'Active'),
('B00152', 'ZE0152         ', 'NYY 4X4 MM2 PULUNG                                ', '                              ', 'K001', 'S002', 'M004', 25000, 21881, 0, '', 'Active'),
('B00153', 'ZE0153         ', 'TWIST 2X10 MM2 SUTRADO                            ', '                              ', 'K001', 'S002', 'M002', 4700, 4279, 0, '', 'Active'),
('B00154', 'ZE0100         ', 'NYY 3X1.5 MM2 PULUNG                              ', '                              ', 'K001', 'S002', 'M004', 0, 8120, 0, '', 'Active'),
('B00155', 'ZE0154         ', 'NYM 3X1.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 7050, 6517, 0, '', 'Active'),
('B00156', 'ZE0155         ', 'NYM 3X1.5 MM2 PULUNG                              ', '                              ', 'K001', 'S002', 'M004', 0, 6284, 0, '', 'Active'),
('B00157', 'ZE0156         ', 'NYM 3X2.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 10000, 9263, 0, '', 'Active'),
('B00158', 'ZE0157         ', 'NYM 3X2.5 MM2 PULUNG                              ', '                              ', 'K001', 'S002', 'M004', 0, 9077, 0, '', 'Active'),
('B00159', 'ZE0158         ', 'NYY 3X2.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 13500, 11961, 0, '', 'Active'),
('B00160', 'ZE0159         ', 'TWIST 2X16 MM2 SUTRADO                            ', '                              ', 'K001', 'S002', 'M002', 6700, 6224, 0, '', 'Active'),
('B00161', 'ZE0160         ', 'NYY 3X6 MM2 SUTRADO                               ', '                              ', 'K001', 'S002', 'M002', 27800, 25771, 0, '', 'Active'),
('B00162', 'ZE0161         ', 'NYY 4X1.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 10700, 10211, 0, '', 'Active'),
('B00163', 'ZE0162         ', 'NYY 4X2.5 MM2 SUTRADO                             ', '                              ', 'K001', 'S002', 'M002', 16500, 14587, 0, '', 'Active'),
('B00164', 'ZE0163         ', 'NYY 4X6 MM2 SUTRADO                               ', '                              ', 'K001', 'S002', 'M002', 35000, 29661, 0, '', 'Active'),
('B00165', 'ZE0164         ', 'NYY 4X10 MM2 SUTRADO                              ', '                              ', 'K001', 'S002', 'M002', 54000, 49597, 0, '', 'Active'),
('B00166', 'ZE0165         ', 'TWIST 4X16 MM2 SUTRADO                            ', '                              ', 'K001', 'S002', 'M002', 14000, 12448, 0, '', 'Active'),
('B00167', 'ZE0166         ', 'TWIST 4X25 MM2 SUTRADO                            ', '                              ', 'K001', 'S002', 'M002', 20800, 18477, 0, '', 'Active'),
('B00168', 'ZE0167         ', 'TWIST 3X35+25 MM2 SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 27000, 23826, 0, '', 'Active'),
('B00169', 'ZE0168         ', 'TWIST 3X50+35 MM2 SUTRADO                         ', '                              ', 'K001', 'S002', 'M002', 38000, 33997, 0, '', 'Active'),
('B00170', 'ZE0169         ', 'NYM 2X2.5 EXTRANA                                 ', '                              ', 'K001', 'S002', 'M010', 0, 8091, 0, '-', 'Active'),
('B00171', 'ZE0170         ', 'NYM 2X1.5 EXTRANA                                 ', '                              ', 'K001', 'S002', 'M010', 0, 5642, 0, '', 'Active'),
('B00172', 'ZE0171         ', 'NYYHY 2X0.75 EXTRANA                              ', '                              ', 'K001', 'S002', 'M010', 0, 3853, 0, '', 'Active'),
('B00173', 'ZE0172         ', 'MESIN GURINDA TANGAN 4\" N 9500N MAKITA            ', '                              ', 'K001', 'S001', 'M006', 1428000, 1400000, 0, '', 'Active'),
('B00174', 'ZE0173', 'NYYHY 3X0.75 ETERNA                               ', '-                ', 'K001', 'S002', 'M008', 8400, 6350, 0, '', 'Active'),
('B00175', 'ZE0175', 'LAPTOP ASUS E21', '1\"', 'K001', 'S001', 'M002', 0, 0, 0, '', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_expedisi`
--

CREATE TABLE `ms_expedisi` (
  `kode_expedisi` char(5) NOT NULL,
  `nama_expedisi` varchar(50) NOT NULL,
  `jasa_expedisi` decimal(10,2) NOT NULL,
  `keterangan_expedisi` text NOT NULL,
  `status_expedisi` enum('Active','Non Active') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_expedisi`
--

INSERT INTO `ms_expedisi` (`kode_expedisi`, `nama_expedisi`, `jasa_expedisi`, `keterangan_expedisi`, `status_expedisi`) VALUES
('100', 'JNE       ', '0.00', '', 'Active'),
('101', 'TIKI      ', '0.00', '', 'Active'),
('102', 'JNT       ', '0.00', '-', 'Active'),
('103', 'GOSEND    ', '0.00', '', 'Active'),
('104', 'GRAB      ', '0.00', '', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_kategori`
--

CREATE TABLE `ms_kategori` (
  `kode_kategori` char(4) NOT NULL,
  `inisial_kategori` char(5) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan_kategori` text NOT NULL,
  `status_kategori` enum('Active','Non Active') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_kategori`
--

INSERT INTO `ms_kategori` (`kode_kategori`, `inisial_kategori`, `nama_kategori`, `keterangan_kategori`, `status_kategori`) VALUES
('K001', 'ZE', 'ELECTRICAL', '-', 'Active'),
('K002', 'ZI', 'IVENTARIS', '', 'Active'),
('K003', 'ZM', 'MECHANICAL ', '', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_merk`
--

CREATE TABLE `ms_merk` (
  `kode_merk` char(4) NOT NULL,
  `inisial_merk` char(5) NOT NULL,
  `nama_merk` varchar(50) NOT NULL,
  `keterangan_merk` text NOT NULL,
  `status_merk` enum('Active','Non Active') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_merk`
--

INSERT INTO `ms_merk` (`kode_merk`, `inisial_merk`, `nama_merk`, `keterangan_merk`, `status_merk`) VALUES
('M001', 'BRC', 'BROCO', '-', 'Active'),
('M002', 'STD', 'SUTRADO', '-', 'Active'),
('M003', 'SCH', 'SCHNEIDER', '-', 'Active'),
('M004', 'PLG', 'PULUNG', '-', 'Active'),
('M005', 'NCH', 'NACHI', '', 'Active'),
('M006', 'MKT', 'MAKITA', '', 'Active'),
('M007', 'CLP', 'CLIPSAL', '', 'Active'),
('M008', 'ETR', 'ETERNA', '', 'Active'),
('M009', 'LGR', 'LEGRAND', '', 'Active'),
('M010', 'EXR', 'EXTRANA', '', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_referensi`
--

CREATE TABLE `ms_referensi` (
  `kode_referensi` char(5) NOT NULL,
  `nama_referensi` varchar(50) NOT NULL,
  `keterangan_referensi` text NOT NULL,
  `status_referensi` enum('Active','Non Active') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_referensi`
--

INSERT INTO `ms_referensi` (`kode_referensi`, `nama_referensi`, `keterangan_referensi`, `status_referensi`) VALUES
('RF001', 'TOKOPEDIA', '-', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_satuan`
--

CREATE TABLE `ms_satuan` (
  `kode_satuan` char(4) NOT NULL,
  `inisial_satuan` char(5) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL,
  `keterangan_satuan` text NOT NULL,
  `status_satuan` enum('Active','Non Active') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_satuan`
--

INSERT INTO `ms_satuan` (`kode_satuan`, `inisial_satuan`, `nama_satuan`, `keterangan_satuan`, `status_satuan`) VALUES
('S001', 'PCS', 'PIECES', '-', 'Active'),
('S002', 'MTR', 'METER', '-', 'Active'),
('S003', 'DRM', 'DRUM', '-', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_supplier`
--

CREATE TABLE `ms_supplier` (
  `kode_supplier` char(5) NOT NULL,
  `inisial_supplier` char(5) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat_supplier` text NOT NULL,
  `jenis_supplier` varchar(50) NOT NULL,
  `telp_supplier` varchar(25) NOT NULL,
  `keterangan_supplier` text NOT NULL,
  `status_supplier` enum('Active','Non Active') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_supplier`
--

INSERT INTO `ms_supplier` (`kode_supplier`, `inisial_supplier`, `nama_supplier`, `alamat_supplier`, `jenis_supplier`, `telp_supplier`, `keterangan_supplier`, `status_supplier`) VALUES
('SU001', 'PSA', 'PUTRA SUMBER ABADI', 'BOGOR', '-', '-', '', 'Active'),
('SU002', 'SKI', 'SUTRAKABEL INTIMANDIRI', 'JL. RODA PEMBANGUNAN', '-', '-', '', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_toko`
--

CREATE TABLE `ms_toko` (
  `nama_toko` varchar(100) NOT NULL,
  `moto_toko` varchar(100) NOT NULL,
  `alamat_toko` text NOT NULL,
  `telp_toko` varchar(50) NOT NULL,
  `email_toko` varchar(50) NOT NULL,
  `keterangan_toko` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_toko`
--

INSERT INTO `ms_toko` (`nama_toko`, `moto_toko`, `alamat_toko`, `telp_toko`, `email_toko`, `keterangan_toko`) VALUES
('ELECTRICAL WAREHOUSE BOGOR', '-', 'Raya Bogor Km. 49,Jl. Roda Pembangunan No. 5. Bogor,Indonesia 16710', '(+6221) 875 3735', '-', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_user`
--

CREATE TABLE `ms_user` (
  `kode_user` char(5) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `telp_user` varchar(50) NOT NULL,
  `alamat_user` text NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `kelamin_user` enum('Pria','Wanita') NOT NULL,
  `username_user` varchar(50) NOT NULL,
  `password_user` varchar(150) NOT NULL,
  `status_user` enum('Active','Non Active') NOT NULL,
  `user_group` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ms_user`
--

INSERT INTO `ms_user` (`kode_user`, `nama_user`, `telp_user`, `alamat_user`, `email_user`, `kelamin_user`, `username_user`, `password_user`, `status_user`, `user_group`) VALUES
('U0001', 'Admin', '-', 'Bogor', '-', 'Pria', 'admin', '166118d9fe52df1659e879365ce16b06', 'Active', 8),
('U0002', 'Sustiyaningsih', '-', '', '-', 'Wanita', 'tya', 'e10adc3949ba59abbe56e057f20f883e', 'Active', 2),
('U0003', 'Farhan Alawi', '081220209020', 'Bogor', 'farhan@sutrakabel.net', 'Pria', 'farhan', '0192023a7bbd73250516f069df18b500', 'Active', 1),
('U0004', 'ADMINISTRATOR', '-', '-', '-', 'Pria', 'administrator', 'cf2d3d3e596b8fdc377e0cb936aaddd3', 'Active', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sys_akses`
--

CREATE TABLE `sys_akses` (
  `akses_id` int(4) NOT NULL,
  `akses_group` int(3) NOT NULL,
  `akses_submenu` int(3) NOT NULL,
  `akses_dibuat` datetime NOT NULL,
  `akses_diubah` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sys_akses`
--

INSERT INTO `sys_akses` (`akses_id`, `akses_group`, `akses_submenu`, `akses_dibuat`, `akses_diubah`) VALUES
(5, 0, 0, '2017-11-27 00:00:00', '0000-00-00 00:00:00'),
(6, 0, 0, '2017-11-27 00:00:00', '0000-00-00 00:00:00'),
(7, 0, 0, '2017-11-27 00:00:00', '0000-00-00 00:00:00'),
(8, 0, 0, '2017-11-27 00:00:00', '0000-00-00 00:00:00'),
(9, 0, 0, '2017-11-27 00:00:00', '0000-00-00 00:00:00'),
(10, 0, 0, '2017-11-27 00:00:00', '0000-00-00 00:00:00'),
(367, 8, 6, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(366, 8, 28, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(365, 8, 8, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(364, 8, 27, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(396, 2, 6, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(395, 2, 8, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(394, 2, 27, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(393, 2, 29, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(392, 2, 11, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(391, 2, 30, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(390, 2, 26, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(389, 2, 17, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(388, 2, 18, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(453, 1, 22, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(452, 1, 18, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(451, 1, 31, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(450, 1, 34, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(449, 1, 17, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(448, 1, 29, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(447, 1, 32, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(446, 1, 26, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(445, 1, 11, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(444, 1, 33, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(443, 1, 30, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(442, 1, 2, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(441, 1, 27, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(440, 1, 3, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(439, 1, 8, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(263, 3, 13, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(262, 3, 22, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(261, 3, 18, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(260, 3, 17, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(259, 3, 26, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(258, 3, 30, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(257, 3, 11, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(256, 3, 2, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(255, 3, 29, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(254, 3, 27, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(253, 3, 3, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(252, 3, 8, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(251, 3, 28, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(438, 1, 28, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(250, 3, 4, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(249, 3, 6, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(248, 3, 7, '2018-04-20 00:00:00', '0000-00-00 00:00:00'),
(387, 2, 22, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(386, 2, 31, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(363, 8, 29, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(362, 8, 11, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(361, 8, 30, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(360, 8, 26, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(359, 8, 17, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(358, 8, 18, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(357, 8, 22, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(356, 8, 31, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(355, 8, 13, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(368, 8, 7, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(437, 1, 4, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(397, 2, 7, '2018-04-23 00:00:00', '0000-00-00 00:00:00'),
(436, 1, 6, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(435, 1, 7, '2018-05-03 00:00:00', '0000-00-00 00:00:00'),
(454, 1, 13, '2018-05-03 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sys_group`
--

CREATE TABLE `sys_group` (
  `group_id` int(3) NOT NULL,
  `group_nama` varchar(35) NOT NULL,
  `group_keterangan` text NOT NULL,
  `group_status` enum('Active','Non Active') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sys_group`
--

INSERT INTO `sys_group` (`group_id`, `group_nama`, `group_keterangan`, `group_status`) VALUES
(1, 'ADMINISTRATOR', '-', 'Active'),
(2, 'OPERATOR', '', 'Active'),
(8, 'ADMIN', '-', 'Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sys_menu`
--

CREATE TABLE `sys_menu` (
  `menu_id` int(3) NOT NULL,
  `menu_nama` varchar(40) NOT NULL,
  `menu_icon` varchar(50) NOT NULL,
  `menu_urutan` int(2) NOT NULL,
  `menu_dibuat` datetime NOT NULL,
  `menu_diubah` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sys_menu`
--

INSERT INTO `sys_menu` (`menu_id`, `menu_nama`, `menu_icon`, `menu_urutan`, `menu_dibuat`, `menu_diubah`) VALUES
(1, 'Pengaturan', 'font-green icon-settings', 1, '2017-11-26 00:00:00', '2017-11-26 00:00:00'),
(2, 'Master Data', 'font-green icon-wallet', 2, '2017-11-26 00:00:00', '2017-11-26 00:00:00'),
(3, 'Transaksi', 'font-green icon-basket', 3, '2017-11-26 00:00:00', '2017-11-26 00:00:00'),
(4, 'Laporan', 'font-green icon-pie-chart', 4, '2017-12-29 00:00:00', '2017-12-29 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sys_submenu`
--

CREATE TABLE `sys_submenu` (
  `submenu_id` int(3) NOT NULL,
  `submenu_nama` varchar(50) NOT NULL,
  `submenu_menu` int(3) NOT NULL,
  `submenu_link` varchar(100) NOT NULL,
  `submenu_urutan` int(3) NOT NULL,
  `submenu_dibuat` datetime NOT NULL,
  `submenu_diubah` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sys_submenu`
--

INSERT INTO `sys_submenu` (`submenu_id`, `submenu_nama`, `submenu_menu`, `submenu_link`, `submenu_urutan`, `submenu_dibuat`, `submenu_diubah`) VALUES
(2, 'Data Pengguna', 1, '?page=dtusr', 3, '2017-11-26 00:00:00', '2018-04-20 00:00:00'),
(3, 'Data Menu & Modul', 1, '?page=dtmdl', 4, '2017-11-26 00:00:00', '2018-04-20 00:00:00'),
(4, 'Data Group Akses', 1, '?page=dtgrp', 2, '2017-11-26 00:00:00', '2018-04-20 00:00:00'),
(6, 'Data Expedisi', 2, '?page=dtexpds', 5, '2017-11-26 00:00:00', '2018-04-18 00:00:00'),
(7, 'Data Barang', 2, '?page=dtitm', 6, '2017-11-26 00:00:00', '2018-04-20 00:00:00'),
(8, 'Data Kategori', 2, '?page=dtktgr', 3, '2017-12-24 00:00:00', '2018-04-20 00:00:00'),
(31, 'Laporan Laba Rugi', 4, '?page=rptlabarugi', 4, '2018-04-23 00:00:00', '2018-04-30 00:00:00'),
(32, 'Data Supplier', 2, '?page=dtsupp', 3, '2018-04-26 00:00:00', '0000-00-00 00:00:00'),
(11, 'Data Sales Invoice', 3, '?page=dtsi', 3, '2017-12-24 00:00:00', '2018-04-24 00:00:00'),
(13, 'Pengaturan Toko', 1, '?page=confstore', 1, '2017-12-24 00:00:00', '0000-00-00 00:00:00'),
(30, 'Data Purchase Invoice', 3, '?page=dtpi', 2, '2018-04-20 00:00:00', '2018-04-24 00:00:00'),
(17, 'Laporan Barang', 4, '?page=rptbrg', 1, '2017-12-29 00:00:00', '2018-04-20 00:00:00'),
(18, 'Laporan Order', 4, '?page=rptodr', 2, '2017-12-29 00:00:00', '2018-04-20 00:00:00'),
(22, 'Laporan Penjualan', 4, '?page=rptpjl', 3, '2017-12-29 00:00:00', '2018-04-20 00:00:00'),
(26, 'Data Satuan', 2, '?page=dtstn', 1, '2018-04-18 00:00:00', '2018-04-20 00:00:00'),
(27, 'Data Merk & Brand', 2, '?page=dtmrk', 2, '2018-04-18 00:00:00', '2018-04-20 00:00:00'),
(28, 'Data Harga Barang', 2, '?page=dthrg', 7, '2018-04-18 00:00:00', '2018-04-20 00:00:00'),
(29, 'Data Transaksi', 3, '?page=dttrx', 1, '2018-04-19 00:00:00', '2018-04-24 00:00:00'),
(33, 'Data Referensi', 2, '?page=dtreff', 4, '2018-04-26 00:00:00', '2018-04-26 00:00:00'),
(34, 'Laporan Harga Barang', 4, '?page=rpthrgbrg', 5, '2018-05-03 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_harga`
--

CREATE TABLE `tr_harga` (
  `id_harga` int(6) NOT NULL,
  `tgl_berlaku` datetime NOT NULL,
  `kode_supplier` char(6) NOT NULL,
  `keterangan_harga` text NOT NULL,
  `kode_user` char(6) NOT NULL,
  `status_harga` enum('Open','Close') NOT NULL,
  `tgl_dibuat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_harga`
--

INSERT INTO `tr_harga` (`id_harga`, `tgl_berlaku`, `kode_supplier`, `keterangan_harga`, `kode_user`, `status_harga`, `tgl_dibuat`) VALUES
(1, '2018-03-12 00:00:00', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 12-03-2018', 'U0004', 'Close', '0000-00-00 00:00:00'),
(2, '2018-05-02 00:00:00', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 02-05-2018', 'U0004', 'Close', '0000-00-00 00:00:00'),
(4, '2018-05-03 00:00:00', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 03-05-2018', 'U0004', 'Close', '0000-00-00 00:00:00'),
(7, '2018-05-03 00:00:00', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 03-05-2018 (TRANSAKSI ITEM)', 'U0004', 'Close', '2018-05-03 14:31:37'),
(8, '2018-05-03 00:00:00', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 03-05-2018 (TRANSAKSI ITEM)', 'U0004', 'Close', '2018-05-03 14:32:57'),
(9, '2018-05-03 14:36:00', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 03-05-2018 (IMPORT)', 'U0004', 'Close', '2018-05-03 14:36:00'),
(10, '2018-05-03 14:36:59', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 03-05-2018 (TRANSAKSI ITEM)', 'U0004', 'Close', '2018-05-03 14:36:59'),
(11, '2018-05-03 14:42:06', '', 'UPDATE HARGA BARANG & PRODUK PADA TANGGAL 03-05-2018 (INSERT)', 'U0004', 'Open', '2018-05-03 14:42:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_harga_item`
--

CREATE TABLE `tr_harga_item` (
  `id_harga_item` int(6) NOT NULL,
  `id_harga` int(6) NOT NULL,
  `kode_barang` char(10) NOT NULL,
  `harga_beli` int(6) NOT NULL,
  `harga_jual` int(6) NOT NULL,
  `kode_user` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_harga_item`
--

INSERT INTO `tr_harga_item` (`id_harga_item`, `id_harga`, `kode_barang`, `harga_beli`, `harga_jual`, `kode_user`) VALUES
(1, 1, 'B00001', 0, 0, ''),
(2, 1, 'B00002', 0, 0, ''),
(3, 1, 'B00003', 28973, 32100, ''),
(4, 1, 'B00004', 28973, 29552, ''),
(5, 1, 'B00005', 28477, 34172, ''),
(6, 1, 'B00006', 1513, 1800, ''),
(7, 1, 'B00007', 28477, 29750, ''),
(8, 1, 'B00008', 28477, 31600, ''),
(9, 1, 'B00009', 29700, 30294, ''),
(10, 1, 'B00010', 29700, 34000, ''),
(11, 1, 'B00011', 32130, 34000, ''),
(12, 1, 'B00012', 1513, 1800, ''),
(13, 1, 'B00013', 1443, 0, ''),
(14, 1, 'B00014', 45628, 46000, ''),
(15, 1, 'B00015', 40392, 41200, ''),
(16, 1, 'B00016', 1443, 0, ''),
(17, 1, 'B00017', 40392, 48470, ''),
(18, 1, 'B00018', 641025, 653845, ''),
(19, 1, 'B00019', 1513, 1800, ''),
(20, 1, 'B00020', 1443, 0, ''),
(21, 1, 'B00021', 1634710, 1667404, ''),
(22, 1, 'B00022', 58162, 59325, ''),
(23, 1, 'B00023', 1513, 1800, ''),
(24, 1, 'B00024', 1443, 0, ''),
(25, 1, 'B00025', 99854, 101850, ''),
(26, 1, 'B00026', 2310, 2500, ''),
(27, 1, 'B00027', 66328, 67654, ''),
(28, 1, 'B00028', 51205, 52229, ''),
(29, 1, 'B00029', 1513, 1800, ''),
(30, 1, 'B00030', 1443, 0, ''),
(31, 1, 'B00031', 2444, 2800, ''),
(32, 1, 'B00032', 2374, 0, ''),
(33, 1, 'B00033', 37052, 37793, ''),
(34, 1, 'B00034', 28259, 28824, ''),
(35, 1, 'B00035', 2444, 2800, ''),
(36, 1, 'B00036', 2374, 0, ''),
(37, 1, 'B00037', 21129, 21551, ''),
(38, 1, 'B00038', 38250, 39000, ''),
(39, 1, 'B00039', 2444, 2800, ''),
(40, 1, 'B00040', 2374, 0, ''),
(41, 1, 'B00041', 13598, 13870, ''),
(42, 1, 'B00042', 10625, 11000, ''),
(43, 1, 'B00043', 2444, 2800, ''),
(44, 1, 'B00044', 2374, 0, ''),
(45, 1, 'B00045', 46750, 55000, ''),
(46, 1, 'B00046', 22100, 23000, ''),
(47, 1, 'B00047', 2444, 2800, ''),
(48, 1, 'B00048', 2374, 0, ''),
(49, 1, 'B00049', 8925, 9103, ''),
(50, 1, 'B00050', 25500, 26010, ''),
(51, 1, 'B00051', 4376, 4700, ''),
(52, 1, 'B00052', 4230, 0, ''),
(53, 1, 'B00053', 17000, 17340, ''),
(54, 1, 'B00054', 10200, 10404, ''),
(55, 1, 'B00055', 4376, 4700, ''),
(56, 1, 'B00056', 4230, 0, ''),
(57, 1, 'B00057', 21250, 21675, ''),
(58, 1, 'B00058', 29750, 30000, ''),
(59, 1, 'B00059', 4376, 4700, ''),
(60, 1, 'B00060', 4230, 0, ''),
(61, 1, 'B00061', 25500, 26010, ''),
(62, 1, 'B00062', 25500, 26010, ''),
(63, 1, 'B00063', 4376, 4700, ''),
(64, 1, 'B00064', 4230, 0, ''),
(65, 1, 'B00065', 600000, 612000, ''),
(66, 1, 'B00066', 2100000, 2142000, ''),
(67, 1, 'B00067', 4376, 4700, ''),
(68, 1, 'B00068', 4230, 0, ''),
(69, 1, 'B00069', 1550000, 1590000, ''),
(70, 1, 'B00070', 875000, 892500, ''),
(71, 1, 'B00071', 6418, 7260, ''),
(72, 1, 'B00072', 6321, 0, ''),
(73, 1, 'B00073', 3600000, 3835000, ''),
(74, 1, 'B00074', 3350000, 3400000, ''),
(75, 1, 'B00075', 6418, 7260, ''),
(76, 1, 'B00076', 6321, 0, ''),
(77, 1, 'B00077', 2600000, 2652000, ''),
(78, 1, 'B00078', 2550000, 2601000, ''),
(79, 1, 'B00079', 6418, 7260, ''),
(80, 1, 'B00080', 6321, 0, ''),
(81, 1, 'B00081', 950000, 969000, ''),
(82, 1, 'B00082', 650000, 663000, ''),
(83, 1, 'B00083', 6418, 7260, ''),
(84, 1, 'B00084', 6321, 0, ''),
(85, 1, 'B00085', 3000000, 3060000, ''),
(86, 1, 'B00086', 2650000, 2703000, ''),
(87, 1, 'B00087', 6418, 7260, ''),
(88, 1, 'B00088', 6321, 0, ''),
(89, 1, 'B00089', 2550000, 2610000, ''),
(90, 1, 'B00090', 1700000, 1734000, ''),
(91, 1, 'B00091', 5074, 5700, ''),
(92, 1, 'B00092', 4934, 0, ''),
(93, 1, 'B00093', 1625000, 1657500, ''),
(94, 1, 'B00094', 1625000, 1657500, ''),
(95, 1, 'B00095', 7215, 7950, ''),
(96, 1, 'B00096', 7169, 0, ''),
(97, 1, 'B00097', 3750000, 3825000, ''),
(98, 1, 'B00098', 900000, 918000, ''),
(99, 1, 'B00099', 6516, 7500, ''),
(100, 1, 'B00100', 32130, 38556, ''),
(101, 1, 'B00101', 550, 580, ''),
(102, 1, 'B00102', 550, 575, ''),
(103, 1, 'B00103', 4550, 5000, ''),
(104, 1, 'B00104', 4550, 5000, ''),
(105, 1, 'B00105', 2115, 2500, ''),
(106, 1, 'B00106', 2115, 2500, ''),
(107, 1, 'B00107', 2115, 2500, ''),
(108, 1, 'B00108', 8121, 9000, ''),
(109, 1, 'B00109', 5443, 7500, ''),
(110, 1, 'B00110', 6418, 0, ''),
(111, 1, 'B00111', 42901, 43758, ''),
(112, 1, 'B00112', 3951, 4030, ''),
(113, 1, 'B00113', 54230, 55315, ''),
(114, 1, 'B00114', 6774, 6909, ''),
(115, 1, 'B00115', 9173, 9356, ''),
(116, 1, 'B00116', 6350, 8500, ''),
(117, 1, 'B00117', 9349, 9536, ''),
(118, 1, 'B00118', 9173, 9356, ''),
(119, 1, 'B00119', 1810, 1899, ''),
(120, 1, 'B00120', 1810, 1899, ''),
(121, 1, 'B00121', 9044, 12000, ''),
(122, 1, 'B00122', 1810, 1899, ''),
(123, 1, 'B00123', 1810, 1899, ''),
(124, 1, 'B00124', 2896, 3070, ''),
(125, 1, 'B00125', 2896, 3070, ''),
(126, 1, 'B00126', 2896, 3070, ''),
(127, 1, 'B00127', 2896, 3070, ''),
(128, 1, 'B00128', 4525, 4615, ''),
(129, 1, 'B00129', 5786, 5901, ''),
(130, 1, 'B00130', 8298, 8463, ''),
(131, 1, 'B00131', 7423, 7571, ''),
(132, 1, 'B00132', 8801, 0, ''),
(133, 1, 'B00133', 10584, 10796, ''),
(134, 1, 'B00134', 16843, 17179, ''),
(135, 1, 'B00135', 21694, 22127, ''),
(136, 1, 'B00136', 8185, 8900, ''),
(137, 1, 'B00137', 11007, 12500, ''),
(138, 1, 'B00138', 10090, 10292, ''),
(139, 1, 'B00139', 13548, 17000, ''),
(140, 1, 'B00140', 450, 500, ''),
(141, 1, 'B00141', 3000, 3600, ''),
(142, 1, 'B00142', 1000, 1020, ''),
(143, 1, 'B00143', 8169, 9500, ''),
(144, 1, 'B00144', 297500, 349000, ''),
(145, 1, 'B00145', 382500, 382500, ''),
(146, 1, 'B00146', 950000, 969000, ''),
(147, 1, 'B00147', 625000, 637500, ''),
(148, 1, 'B00148', 800000, 816000, ''),
(149, 1, 'B00149', 2250000, 2295000, ''),
(150, 1, 'B00150', 825000, 841500, ''),
(151, 1, 'B00151', 22367, 25000, ''),
(152, 1, 'B00152', 21881, 25000, ''),
(153, 1, 'B00153', 4279, 4700, ''),
(154, 1, 'B00154', 8120, 0, ''),
(155, 1, 'B00155', 6517, 7050, ''),
(156, 1, 'B00156', 6284, 0, ''),
(157, 1, 'B00157', 9263, 10000, ''),
(158, 1, 'B00158', 9077, 0, ''),
(159, 1, 'B00159', 11961, 13500, ''),
(160, 1, 'B00160', 6224, 6700, ''),
(161, 1, 'B00161', 25771, 27800, ''),
(162, 1, 'B00162', 10211, 10700, ''),
(163, 1, 'B00163', 14587, 16500, ''),
(164, 1, 'B00164', 29661, 35000, ''),
(165, 1, 'B00165', 49597, 54000, ''),
(166, 1, 'B00166', 12448, 14000, ''),
(167, 1, 'B00167', 18477, 20800, ''),
(168, 1, 'B00168', 23826, 27000, ''),
(169, 1, 'B00169', 33997, 38000, ''),
(170, 1, 'B00170', 8091, 0, ''),
(171, 1, 'B00171', 5642, 0, ''),
(172, 1, 'B00172', 3853, 0, ''),
(173, 1, 'B00173', 1400000, 1428000, ''),
(174, 1, 'B00174', 6350, 8400, ''),
(431, 2, 'B00014', 45628, 46000, ''),
(432, 2, 'B00078', 2550000, 2601000, ''),
(433, 2, 'B00142', 1000, 1020, ''),
(434, 2, 'B00027', 66328, 67654, ''),
(435, 2, 'B00091', 5074, 5700, ''),
(436, 2, 'B00155', 6517, 7050, ''),
(437, 2, 'B00040', 2374, 0, ''),
(438, 2, 'B00104', 4550, 5000, ''),
(439, 2, 'B00168', 23826, 27000, ''),
(440, 2, 'B00053', 17000, 17340, ''),
(441, 2, 'B00117', 9349, 9536, ''),
(442, 2, 'B00001', 0, 0, ''),
(443, 2, 'B00066', 2100000, 2142000, ''),
(444, 2, 'B00130', 8298, 8463, ''),
(445, 2, 'B00015', 40392, 41200, ''),
(446, 2, 'B00079', 6418, 7260, ''),
(447, 2, 'B00143', 8169, 9500, ''),
(448, 2, 'B00028', 51205, 52229, ''),
(449, 2, 'B00092', 4934, 0, ''),
(450, 2, 'B00156', 6284, 0, ''),
(451, 2, 'B00041', 13598, 13870, ''),
(452, 2, 'B00105', 2115, 2500, ''),
(453, 2, 'B00169', 33997, 38000, ''),
(454, 2, 'B00054', 10200, 10404, ''),
(455, 2, 'B00118', 9173, 9356, ''),
(456, 2, 'B00002', 0, 0, ''),
(457, 2, 'B00067', 4376, 4700, ''),
(458, 2, 'B00131', 7423, 7571, ''),
(459, 2, 'B00016', 1443, 0, ''),
(460, 2, 'B00080', 6321, 0, ''),
(461, 2, 'B00144', 297500, 349000, ''),
(462, 2, 'B00029', 1513, 1800, ''),
(463, 2, 'B00093', 1625000, 1657500, ''),
(464, 2, 'B00157', 9263, 10000, ''),
(465, 2, 'B00042', 10625, 11000, ''),
(466, 2, 'B00106', 2115, 2500, ''),
(467, 2, 'B00170', 8091, 0, ''),
(468, 2, 'B00055', 4376, 4700, ''),
(469, 2, 'B00119', 1810, 1899, ''),
(470, 2, 'B00003', 28973, 32100, ''),
(471, 2, 'B00068', 4230, 0, ''),
(472, 2, 'B00132', 8801, 0, ''),
(473, 2, 'B00017', 40392, 48470, ''),
(474, 2, 'B00081', 950000, 969000, ''),
(475, 2, 'B00145', 382500, 382500, ''),
(476, 2, 'B00030', 1443, 0, ''),
(477, 2, 'B00094', 1625000, 1657500, ''),
(478, 2, 'B00158', 9077, 0, ''),
(479, 2, 'B00043', 2444, 2800, ''),
(480, 2, 'B00107', 2115, 2500, ''),
(481, 2, 'B00171', 5642, 0, ''),
(482, 2, 'B00056', 4230, 0, ''),
(483, 2, 'B00120', 1810, 1899, ''),
(484, 2, 'B00004', 28973, 29552, ''),
(485, 2, 'B00069', 1550000, 1590000, ''),
(486, 2, 'B00133', 10584, 10796, ''),
(487, 2, 'B00018', 641025, 653845, ''),
(488, 2, 'B00082', 650000, 663000, ''),
(489, 2, 'B00146', 950000, 969000, ''),
(490, 2, 'B00031', 2444, 2800, ''),
(491, 2, 'B00095', 7215, 7950, ''),
(492, 2, 'B00159', 11961, 13500, ''),
(493, 2, 'B00044', 2374, 0, ''),
(494, 2, 'B00108', 8121, 9000, ''),
(495, 2, 'B00172', 3853, 0, ''),
(496, 2, 'B00057', 21250, 21675, ''),
(497, 2, 'B00121', 9044, 12000, ''),
(498, 2, 'B00005', 28477, 34172, ''),
(499, 2, 'B00070', 875000, 892500, ''),
(500, 2, 'B00134', 16843, 17179, ''),
(501, 2, 'B00019', 1513, 1800, ''),
(502, 2, 'B00083', 6418, 7260, ''),
(503, 2, 'B00147', 625000, 637500, ''),
(504, 2, 'B00032', 2374, 0, ''),
(505, 2, 'B00096', 7169, 0, ''),
(506, 2, 'B00160', 6224, 6700, ''),
(507, 2, 'B00045', 46750, 55000, ''),
(508, 2, 'B00109', 5443, 7500, ''),
(509, 2, 'B00173', 1400000, 1428000, ''),
(510, 2, 'B00058', 29750, 30000, ''),
(511, 2, 'B00122', 1810, 1899, ''),
(512, 2, 'B00007', 28477, 29750, ''),
(513, 2, 'B00071', 6418, 7260, ''),
(514, 2, 'B00135', 21694, 22127, ''),
(515, 2, 'B00020', 1443, 0, ''),
(516, 2, 'B00084', 6321, 0, ''),
(517, 2, 'B00148', 800000, 816000, ''),
(518, 2, 'B00033', 37052, 37793, ''),
(519, 2, 'B00097', 3750000, 3825000, ''),
(520, 2, 'B00161', 25771, 27800, ''),
(521, 2, 'B00046', 22100, 23000, ''),
(522, 2, 'B00110', 6418, 0, ''),
(523, 2, 'B00174', 6350, 8400, ''),
(524, 2, 'B00059', 4376, 4700, ''),
(525, 2, 'B00123', 1810, 1899, ''),
(526, 2, 'B00008', 28477, 31600, ''),
(527, 2, 'B00072', 6321, 0, ''),
(528, 2, 'B00136', 8185, 8900, ''),
(529, 2, 'B00021', 1634710, 1667404, ''),
(530, 2, 'B00085', 3000000, 3060000, ''),
(531, 2, 'B00149', 2250000, 2295000, ''),
(532, 2, 'B00034', 28259, 28824, ''),
(533, 2, 'B00098', 900000, 918000, ''),
(534, 2, 'B00162', 10211, 10700, ''),
(535, 2, 'B00047', 2444, 2800, ''),
(536, 2, 'B00111', 42901, 43758, ''),
(537, 2, 'B00060', 4230, 0, ''),
(538, 2, 'B00124', 2896, 3070, ''),
(539, 2, 'B00009', 29700, 30294, ''),
(540, 2, 'B00073', 3600000, 3835000, ''),
(541, 2, 'B00137', 11007, 12500, ''),
(542, 2, 'B00022', 58162, 59325, ''),
(543, 2, 'B00086', 2650000, 2703000, ''),
(544, 2, 'B00150', 825000, 841500, ''),
(545, 2, 'B00035', 2444, 2800, ''),
(546, 2, 'B00099', 6516, 7500, ''),
(547, 2, 'B00163', 14587, 16500, ''),
(548, 2, 'B00048', 2374, 0, ''),
(549, 2, 'B00112', 3951, 4030, ''),
(550, 2, 'B00061', 25500, 26010, ''),
(551, 2, 'B00125', 2896, 3070, ''),
(552, 2, 'B00010', 29700, 34000, ''),
(553, 2, 'B00074', 3350000, 3400000, ''),
(554, 2, 'B00138', 10090, 10292, ''),
(555, 2, 'B00023', 1513, 1800, ''),
(556, 2, 'B00087', 6418, 7260, ''),
(557, 2, 'B00151', 22367, 25000, ''),
(558, 2, 'B00036', 2374, 0, ''),
(559, 2, 'B00100', 32130, 38556, ''),
(560, 2, 'B00164', 29661, 35000, ''),
(561, 2, 'B00049', 8925, 9103, ''),
(562, 2, 'B00113', 54230, 55315, ''),
(563, 2, 'B00062', 25500, 26010, ''),
(564, 2, 'B00126', 2896, 3070, ''),
(565, 2, 'B00011', 32130, 34000, ''),
(566, 2, 'B00075', 6418, 7260, ''),
(567, 2, 'B00139', 13548, 17000, ''),
(568, 2, 'B00024', 1443, 0, ''),
(569, 2, 'B00088', 6321, 0, ''),
(570, 2, 'B00152', 21881, 25000, ''),
(571, 2, 'B00037', 21129, 21551, ''),
(572, 2, 'B00101', 550, 580, ''),
(573, 2, 'B00165', 49597, 54000, ''),
(574, 2, 'B00050', 25500, 26010, ''),
(575, 2, 'B00114', 6774, 6909, ''),
(576, 2, 'B00063', 4376, 4700, ''),
(577, 2, 'B00127', 2896, 3070, ''),
(578, 2, 'B00012', 1513, 1800, ''),
(579, 2, 'B00076', 6321, 0, ''),
(580, 2, 'B00140', 450, 500, ''),
(581, 2, 'B00025', 99854, 101850, ''),
(582, 2, 'B00089', 2550000, 2610000, ''),
(583, 2, 'B00153', 4279, 4700, ''),
(584, 2, 'B00038', 38250, 39000, ''),
(585, 2, 'B00102', 550, 575, ''),
(586, 2, 'B00166', 12448, 14000, ''),
(587, 2, 'B00051', 4376, 4700, ''),
(588, 2, 'B00115', 9173, 9356, ''),
(589, 2, 'B00064', 4230, 0, ''),
(590, 2, 'B00128', 4525, 4615, ''),
(591, 2, 'B00013', 1443, 0, ''),
(592, 2, 'B00077', 2600000, 2652000, ''),
(593, 2, 'B00141', 3000, 3600, ''),
(594, 2, 'B00026', 2310, 2500, ''),
(595, 2, 'B00090', 1700000, 1734000, ''),
(596, 2, 'B00154', 8120, 0, ''),
(597, 2, 'B00039', 2444, 2800, ''),
(598, 2, 'B00103', 4550, 5000, ''),
(599, 2, 'B00167', 18477, 20800, ''),
(600, 2, 'B00052', 4230, 0, ''),
(601, 2, 'B00116', 6350, 8500, ''),
(602, 2, 'B00065', 600000, 612000, ''),
(603, 2, 'B00129', 5786, 5901, ''),
(604, 2, 'B00175', 2450000, 2600000, ''),
(780, 4, 'B00175', 3050000, 3750000, ''),
(957, 7, 'B00175', 2105000, 3750000, ''),
(1132, 8, 'B00175', 2105000, 3750000, ''),
(1307, 9, 'B00175', 2100000, 2500000, ''),
(1482, 10, 'B00175', 2105000, 3750000, ''),
(1657, 11, 'B00175', 2400000, 2500000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_pembelian`
--

CREATE TABLE `tr_pembelian` (
  `kode_pembelian` char(40) NOT NULL,
  `kode_transaksi` char(30) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `kode_supplier` char(6) NOT NULL,
  `total_pembelian` int(6) NOT NULL,
  `status_pembelian` enum('Open','Close','Cancel') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_pembelian`
--

INSERT INTO `tr_pembelian` (`kode_pembelian`, `kode_transaksi`, `tgl_pembelian`, `kode_supplier`, `total_pembelian`, `status_pembelian`) VALUES
('0001/PSA/IV/18', '0001/ODR/IV/18', '2018-04-30', 'SU001', 950000, 'Close'),
('0001/SKI/V/18', '0004/ODR/V/18', '2018-05-03', 'SU002', 5830624, 'Close'),
('0002/PSA/III/18', '0002/ODR/III/18', '2018-03-19', 'SU001', 1400000, 'Close'),
('0002/PSA/IV/18', '0002/ODR/IV/18', '2018-04-30', 'SU001', 641025, 'Close'),
('0002/PSA/V/18', '0002/ODR/V/18', '2018-05-03', 'SU001', 6100000, 'Open'),
('0002/SKI/V/18', '0005/ODR/V/18', '2018-05-03', 'SU002', 2105000, 'Close'),
('0003/PSA/III/18', '0003/ODR/III/18', '2018-03-19', 'SU001', 1487520, 'Close'),
('0003/PSA/IV/18', '0003/ODR/IV/18', '2018-04-11', 'SU001', 23100, 'Close'),
('0003/PSA/V/18', '0003/ODR/V/18', '2018-05-03', 'SU001', 3050000, 'Open'),
('0004/PSA/III/18', '0004/ODR/III/18', '2018-03-19', 'SU001', 1282050, 'Close');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_pembelian_item`
--

CREATE TABLE `tr_pembelian_item` (
  `id_pembelian_item` int(11) NOT NULL,
  `id_transaksi_item` int(6) NOT NULL,
  `kode_pembelian` char(50) NOT NULL,
  `kode_barang` char(7) NOT NULL,
  `harga_pembelian` int(6) NOT NULL,
  `jumlah_pembelian` int(6) NOT NULL,
  `keterangan_pembelian_item` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_pembelian_item`
--

INSERT INTO `tr_pembelian_item` (`id_pembelian_item`, `id_transaksi_item`, `kode_pembelian`, `kode_barang`, `harga_pembelian`, `jumlah_pembelian`, `keterangan_pembelian_item`) VALUES
(10, 14, '0003/PSA/V/18', 'B00175', 2105000, 1, ''),
(2, 0, '0001/PSA/IV/18', 'B00081', 950000, 1, ''),
(3, 0, '0002/PSA/III/18', 'B00173', 1400000, 1, ''),
(4, 0, '0003/PSA/III/18', 'B00051', 4376, 20, ''),
(5, 0, '0002/PSA/IV/18', 'B00018', 641025, 1, ''),
(6, 0, '0004/PSA/III/18', 'B00018', 641025, 2, ''),
(7, 0, '0003/PSA/IV/18', 'B00026', 2310, 10, ''),
(9, 0, '0002/PSA/V/18', 'B00175', 3050000, 2, ''),
(11, 18, '0001/SKI/V/18', 'B00086', 2650000, 2, ''),
(12, 20, '0002/SKI/V/18', 'B00175', 2105000, 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_penjualan`
--

CREATE TABLE `tr_penjualan` (
  `kode_penjualan` char(50) NOT NULL,
  `kode_transaksi` char(30) NOT NULL,
  `tgl_penjualan` datetime NOT NULL,
  `kode_expedisi` char(5) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `kode_referensi` char(6) NOT NULL,
  `no_referensi` varchar(50) NOT NULL,
  `alamat_customer` text NOT NULL,
  `telp_customer` varchar(30) NOT NULL,
  `total_ongkir` int(6) NOT NULL,
  `total_penjualan` int(6) NOT NULL,
  `status_penjualan` enum('Close','Open','Cancel') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_penjualan`
--

INSERT INTO `tr_penjualan` (`kode_penjualan`, `kode_transaksi`, `tgl_penjualan`, `kode_expedisi`, `nama_customer`, `kode_referensi`, `no_referensi`, `alamat_customer`, `telp_customer`, `total_ongkir`, `total_penjualan`, `status_penjualan`) VALUES
('0003/RF001/V/18', '0003/ODR/V/18', '2018-05-03 00:00:00', '102', 'RAYMOND', 'RF001', '546456546456', 'JL. RODA PEMBANGUNAN NO 01', '-', 35000, 3750000, 'Open'),
('0004/RF001/V/18', '0004/ODR/V/18', '2018-05-03 00:00:00', '103', 'FARHAN ALAWI', 'RF001', '6879789564654', 'JL. KOLONEL BUSTOMI BURHANUDIN NO 05', '081220209020', 55000, 5947232, 'Open'),
('0001/RF001/IV/18', '0001/ODR/IV/18', '2018-04-30 00:00:00', '104', 'SETIAWAN SALIM', 'RF001', 'INV/20180316/XVIII/III/143469874', 'PERUMAHAN CIRIUNG CEMERLANG BLOK G8 RT.02/14 CIRIUNG, CIBINONG, KAB. BOGOR CIBINONG, KAB. BOGOR, 16918', '08999579057', 13000, 969000, 'Close'),
('0002/RF001/III/18', '0002/ODR/III/18', '2018-03-19 00:00:00', '104', 'SARI', 'RF001', 'INV/20180316/XVIII/III/143544476', 'TAMAN PAGELARAN JALAN NILA 1 NO. 1 CIOMAS, KAB. BOGOR, 16610 JAWA BARAT', '087873746624', 20856, 1428000, 'Close'),
('0003/RF001/III/18', '0003/ODR/III/18', '2018-03-19 00:00:00', '104', 'ANDIKA ARDIANSYAH', 'RF001', 'INV/20180316/XVIII/III/143492871', 'KP BENDUNGAN RT 01/06 KEL CILODONG KEC CILODONG KOTA DEPOK NO 60 CILODONG, KOTA DEPOK, 16414', '085694526848', 13000, 1522000, 'Close'),
('0002/RF001/IV/18', '0002/ODR/IV/18', '2018-04-30 00:00:00', '104', 'MUHAMAD RAMDANI', 'RF001', 'INV/20180316/XVIII/III/143631600', 'JL NOBLE / PAHLAWAN SABEKI RT 003 RW 02 NO. 97 KP. PONDOK MANGGIS DESA BOJONG BARU BOJONGGEDE, KAB. BOGOR, 16320', '081297690088', 15616, 653845, 'Close'),
('0004/RF001/III/18', '0004/ODR/III/18', '2018-03-19 00:00:00', '100', 'MAWI / MAEMUNAH', 'RF001', 'INV/20180315/XVIII/III/143323540', 'SITUPETE RT 01 RW 06 TANAH SEREAL, KOTA BOGOR, 16166 JAWA BARAT', '083811704818', 16616, 1307690, 'Close'),
('0003/RF001/IV/18', '0003/ODR/IV/18', '2018-04-11 00:00:00', '103', 'ANDREAS BUDIMAN', 'RF001', 'INV/20180410/XVIII/IV/150475352', 'PT. PRISSANT DELI KRISP JL. RAYA SENTUL KM 2,7 BLOK IIIB SENTUL, BOGOR 16810 - INDONESIA MOBILE: 0816-1777-4684 PHONE: 021-87954082 BABAKAN MADANG, KAB. BOGOR, 16810', '', 15000, 25000, 'Open'),
('0002/RF001/V/18', '0002/ODR/V/18', '2018-05-03 00:00:00', '100', 'RAYMOND', 'RF001', '564654654656', 'JL. ALTERNATIF SENTUL NO 01', '-', 25000, 7500000, 'Open'),
('0005/RF001/V/18', '0005/ODR/V/18', '2018-05-03 00:00:00', '102', 'UJANG', 'RF001', '99288466502', 'JL. RAYA PADJAJARAN NO 01 ', '-', 15000, 3750000, 'Close');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_penjualan_item`
--

CREATE TABLE `tr_penjualan_item` (
  `id_penjualan_item` int(6) NOT NULL,
  `id_transaksi_item` int(6) NOT NULL,
  `kode_penjualan` char(50) NOT NULL,
  `kode_barang` char(7) NOT NULL,
  `harga_penjualan` int(10) NOT NULL,
  `jumlah_penjualan` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_penjualan_item`
--

INSERT INTO `tr_penjualan_item` (`id_penjualan_item`, `id_transaksi_item`, `kode_penjualan`, `kode_barang`, `harga_penjualan`, `jumlah_penjualan`) VALUES
(10, 14, '0003/RF001/V/18', 'B00175', 3750000, 1),
(2, 0, '0001/RF001/IV/18', 'B00081', 969000, 1),
(3, 0, '0002/RF001/III/18', 'B00173', 1428000, 1),
(4, 0, '0003/RF001/III/18', 'B00051', 4700, 20),
(5, 0, '0002/RF001/IV/18', 'B00018', 653845, 1),
(6, 0, '0004/RF001/III/18', 'B00018', 653845, 2),
(7, 0, '0003/RF001/IV/18', 'B00026', 2500, 10),
(9, 0, '0002/RF001/V/18', 'B00175', 3750000, 2),
(11, 18, '0004/RF001/V/18', 'B00086', 2703000, 2),
(12, 20, '0005/RF001/V/18', 'B00175', 3750000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_pi`
--

CREATE TABLE `tr_pi` (
  `kode_pi` char(25) NOT NULL,
  `tgl_pi` date NOT NULL,
  `kode_supplier` char(6) NOT NULL,
  `keterangan_pi` text NOT NULL,
  `kode_user` char(6) NOT NULL,
  `no_referensi` varchar(50) NOT NULL,
  `status_pi` enum('Open','Close') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_pi`
--

INSERT INTO `tr_pi` (`kode_pi`, `tgl_pi`, `kode_supplier`, `keterangan_pi`, `kode_user`, `no_referensi`, `status_pi`) VALUES
('0001/PI/IV/18', '2018-04-30', 'SU001', '', 'U0004', '', 'Open'),
('0001/PI/V/18', '2018-05-03', 'SU002', '-', 'U0004', '-', 'Open'),
('0002/PI/IV/18', '2018-04-30', 'SU001', '', 'U0004', '-', 'Close'),
('0003/PI/IV/18', '2018-04-30', 'SU001', '-', 'U0004', '-', 'Open'),
('0004/PI/IV/18', '2018-04-30', 'SU001', '', 'U0004', '', 'Close'),
('0005/PI/IV/18', '2018-04-30', 'SU001', '-', 'U0004', '-', 'Close');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_pi_item`
--

CREATE TABLE `tr_pi_item` (
  `id_pi_item` int(6) NOT NULL,
  `kode_pi` char(25) NOT NULL,
  `kode_transaksi` char(30) NOT NULL,
  `kode_pembelian` char(30) NOT NULL,
  `total_pembelian` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_pi_item`
--

INSERT INTO `tr_pi_item` (`id_pi_item`, `kode_pi`, `kode_transaksi`, `kode_pembelian`, `total_pembelian`) VALUES
(1, '0001/PI/IV/18', '0001/ODR/III/18', '0001/PSA/III/18', 543000),
(2, '0002/PI/IV/18', '0001/ODR/IV/18', '0001/PSA/IV/18', 950000),
(3, '0002/PI/IV/18', '0002/ODR/III/18', '0002/PSA/III/18', 1400000),
(4, '0003/PI/IV/18', '0002/ODR/IV/18', '0002/PSA/IV/18', 641025),
(5, '0004/PI/IV/18', '0003/ODR/III/18', '0003/PSA/III/18', 1487520),
(6, '0004/PI/IV/18', '0004/ODR/III/18', '0004/PSA/III/18', 1282050),
(7, '0005/PI/IV/18', '0003/ODR/IV/18', '0003/PSA/IV/18', 23100),
(8, '0001/PI/V/18', '0004/ODR/V/18', '0001/SKI/V/18', 5830624),
(9, '0001/PI/V/18', '0005/ODR/V/18', '0002/SKI/V/18', 2105000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_retur_jual`
--

CREATE TABLE `tr_retur_jual` (
  `kode_retur_jual` char(30) NOT NULL,
  `tgl_retur_jual` datetime NOT NULL,
  `no_referensi` varchar(100) NOT NULL,
  `kode_penjualan` char(50) NOT NULL,
  `kode_user` char(5) NOT NULL,
  `keterangan_retur_jual` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_retur_jual`
--

INSERT INTO `tr_retur_jual` (`kode_retur_jual`, `tgl_retur_jual`, `no_referensi`, `kode_penjualan`, `kode_user`, `keterangan_retur_jual`) VALUES
('001/RTR/IV/2018', '2018-04-21 00:00:00', '', '030/OL/IV/2018', 'U0003', 'BARANG RETUR MINTA DITUKAR');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_retur_jual_item`
--

CREATE TABLE `tr_retur_jual_item` (
  `id_retur_jual_item` int(5) NOT NULL,
  `kode_retur_jual` char(30) NOT NULL,
  `id_penjualan_item` int(6) NOT NULL,
  `kode_barang` char(8) NOT NULL,
  `harga_retur_jual` int(6) NOT NULL,
  `jumlah_retur_jual` int(6) NOT NULL,
  `alasan_retur_jual` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_retur_jual_item`
--

INSERT INTO `tr_retur_jual_item` (`id_retur_jual_item`, `kode_retur_jual`, `id_penjualan_item`, `kode_barang`, `harga_retur_jual`, `jumlah_retur_jual`, `alasan_retur_jual`) VALUES
(4, '001/RTR/IV/2018', 51, 'B00150', 841500, 1, 'TIDAK BERFUNGSI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_retur_jual_tmp`
--

CREATE TABLE `tr_retur_jual_tmp` (
  `id` int(3) NOT NULL,
  `id_penjualan_item` int(6) NOT NULL,
  `kode_barang` char(8) NOT NULL,
  `harga_retur_jual` int(6) NOT NULL,
  `jumlah_retur_jual` int(4) NOT NULL,
  `alasan_retur_jual` text NOT NULL,
  `kode_user` char(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_si`
--

CREATE TABLE `tr_si` (
  `kode_si` char(30) NOT NULL,
  `tgl_si` date NOT NULL,
  `kode_referensi` char(6) NOT NULL,
  `keterangan_si` text NOT NULL,
  `kode_user` char(6) NOT NULL,
  `total_si` int(6) NOT NULL,
  `status_si` enum('Open','Close') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_si`
--

INSERT INTO `tr_si` (`kode_si`, `tgl_si`, `kode_referensi`, `keterangan_si`, `kode_user`, `total_si`, `status_si`) VALUES
('0001/SI/IV/18', '2018-04-30', 'RF001', '', 'U0004', 0, 'Close'),
('0001/SI/V/18', '2018-05-03', 'RF001', '', 'U0004', 0, 'Open'),
('0002/SI/IV/18', '2018-04-30', 'RF001', '', 'U0004', 0, 'Open'),
('0003/SI/IV/18', '2018-04-30', 'RF001', '', 'U0004', 0, 'Close'),
('0004/SI/IV/18', '2018-04-30', 'RF001', '', 'U0004', 0, 'Open');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_si_item`
--

CREATE TABLE `tr_si_item` (
  `id_si_item` int(6) NOT NULL,
  `kode_si` char(30) NOT NULL,
  `kode_penjualan` char(30) NOT NULL,
  `kode_transaksi` char(30) NOT NULL,
  `total_penjualan` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_si_item`
--

INSERT INTO `tr_si_item` (`id_si_item`, `kode_si`, `kode_penjualan`, `kode_transaksi`, `total_penjualan`) VALUES
(1, '0001/SI/IV/18', '0002/RF001/III/18', '0002/ODR/III/18', 1428000),
(2, '0002/SI/IV/18', '0001/RF001/IV/18', '0001/ODR/IV/18', 969000),
(3, '0002/SI/IV/18', '0001/RF001/III/18', '0001/ODR/III/18', 569700),
(4, '0003/SI/IV/18', '0004/RF001/III/18', '0004/ODR/III/18', 1307690),
(5, '0004/SI/IV/18', '0002/RF001/IV/18', '0002/ODR/IV/18', 653845),
(6, '0004/SI/IV/18', '0003/RF001/III/18', '0003/ODR/III/18', 1522000),
(7, '0001/SI/V/18', '0005/RF001/V/18', '0005/ODR/V/18', 3750000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_transaksi`
--

CREATE TABLE `tr_transaksi` (
  `kode_transaksi` char(30) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `kode_user` char(5) NOT NULL,
  `status_transaksi` enum('Close','Open','Cancel') NOT NULL,
  `tgl_dibuat` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_transaksi`
--

INSERT INTO `tr_transaksi` (`kode_transaksi`, `tgl_transaksi`, `kode_user`, `status_transaksi`, `tgl_dibuat`) VALUES
('0003/ODR/V/18', '2018-05-03 00:00:00', 'U0004', 'Open', '0000-00-00 00:00:00'),
('0001/ODR/IV/18', '2018-04-30 00:00:00', 'U0004', 'Close', '0000-00-00 00:00:00'),
('0002/ODR/III/18', '2018-03-19 00:00:00', 'U0004', 'Close', '0000-00-00 00:00:00'),
('0003/ODR/III/18', '2018-03-19 00:00:00', 'U0004', 'Close', '0000-00-00 00:00:00'),
('0002/ODR/IV/18', '2018-04-30 00:00:00', 'U0004', 'Close', '0000-00-00 00:00:00'),
('0004/ODR/III/18', '2018-03-19 00:00:00', 'U0004', 'Close', '0000-00-00 00:00:00'),
('0003/ODR/IV/18', '2018-04-11 00:00:00', 'U0004', 'Close', '0000-00-00 00:00:00'),
('0002/ODR/V/18', '2018-05-03 00:00:00', 'U0004', 'Open', '0000-00-00 00:00:00'),
('0004/ODR/V/18', '2018-05-03 00:00:00', 'U0004', 'Close', '2018-05-03 13:44:50'),
('0005/ODR/V/18', '2018-05-03 00:00:00', 'U0004', 'Close', '2018-05-03 14:39:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_transaksi_item`
--

CREATE TABLE `tr_transaksi_item` (
  `id_transaksi_item` int(6) NOT NULL,
  `kode_transaksi` char(30) NOT NULL,
  `kode_barang` char(6) NOT NULL,
  `harga_pembelian` int(6) NOT NULL,
  `harga_penjualan` int(6) NOT NULL,
  `jumlah_transaksi` int(6) NOT NULL,
  `kode_user` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_transaksi_item`
--

INSERT INTO `tr_transaksi_item` (`id_transaksi_item`, `kode_transaksi`, `kode_barang`, `harga_pembelian`, `harga_penjualan`, `jumlah_transaksi`, `kode_user`) VALUES
(2, '0001/ODR/IV/18', 'B00081', 950000, 969000, 1, ''),
(3, '0002/ODR/III/18', 'B00173', 1400000, 1428000, 1, ''),
(4, '0003/ODR/III/18', 'B00051', 4376, 4700, 20, ''),
(5, '0003/ODR/III/18', 'B00173', 1400000, 1428000, 1, ''),
(6, '0002/ODR/IV/18', 'B00018', 641025, 653845, 1, ''),
(7, '0004/ODR/III/18', 'B00018', 641025, 653845, 2, ''),
(8, '0003/ODR/IV/18', 'B00026', 2310, 2500, 10, ''),
(13, '0002/ODR/V/18', 'B00175', 3050000, 3750000, 2, ''),
(14, '0003/ODR/V/18', 'B00175', 2105000, 3750000, 1, ''),
(18, '0004/ODR/V/18', 'B00086', 2650000, 2703000, 2, ''),
(19, '0004/ODR/V/18', 'B00027', 66328, 67654, 8, ''),
(20, '0005/ODR/V/18', 'B00175', 2105000, 3750000, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ms_barang`
--
ALTER TABLE `ms_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indeks untuk tabel `ms_expedisi`
--
ALTER TABLE `ms_expedisi`
  ADD PRIMARY KEY (`kode_expedisi`);

--
-- Indeks untuk tabel `ms_kategori`
--
ALTER TABLE `ms_kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indeks untuk tabel `ms_merk`
--
ALTER TABLE `ms_merk`
  ADD PRIMARY KEY (`kode_merk`);

--
-- Indeks untuk tabel `ms_referensi`
--
ALTER TABLE `ms_referensi`
  ADD PRIMARY KEY (`kode_referensi`);

--
-- Indeks untuk tabel `ms_satuan`
--
ALTER TABLE `ms_satuan`
  ADD PRIMARY KEY (`kode_satuan`);

--
-- Indeks untuk tabel `ms_supplier`
--
ALTER TABLE `ms_supplier`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- Indeks untuk tabel `ms_user`
--
ALTER TABLE `ms_user`
  ADD PRIMARY KEY (`kode_user`);

--
-- Indeks untuk tabel `sys_akses`
--
ALTER TABLE `sys_akses`
  ADD PRIMARY KEY (`akses_id`);

--
-- Indeks untuk tabel `sys_group`
--
ALTER TABLE `sys_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indeks untuk tabel `sys_menu`
--
ALTER TABLE `sys_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indeks untuk tabel `sys_submenu`
--
ALTER TABLE `sys_submenu`
  ADD PRIMARY KEY (`submenu_id`);

--
-- Indeks untuk tabel `tr_harga`
--
ALTER TABLE `tr_harga`
  ADD PRIMARY KEY (`id_harga`);

--
-- Indeks untuk tabel `tr_harga_item`
--
ALTER TABLE `tr_harga_item`
  ADD PRIMARY KEY (`id_harga_item`);

--
-- Indeks untuk tabel `tr_pembelian`
--
ALTER TABLE `tr_pembelian`
  ADD PRIMARY KEY (`kode_pembelian`);

--
-- Indeks untuk tabel `tr_pembelian_item`
--
ALTER TABLE `tr_pembelian_item`
  ADD PRIMARY KEY (`id_pembelian_item`);

--
-- Indeks untuk tabel `tr_penjualan`
--
ALTER TABLE `tr_penjualan`
  ADD PRIMARY KEY (`kode_penjualan`);

--
-- Indeks untuk tabel `tr_penjualan_item`
--
ALTER TABLE `tr_penjualan_item`
  ADD PRIMARY KEY (`id_penjualan_item`);

--
-- Indeks untuk tabel `tr_pi`
--
ALTER TABLE `tr_pi`
  ADD PRIMARY KEY (`kode_pi`);

--
-- Indeks untuk tabel `tr_pi_item`
--
ALTER TABLE `tr_pi_item`
  ADD PRIMARY KEY (`id_pi_item`);

--
-- Indeks untuk tabel `tr_retur_jual`
--
ALTER TABLE `tr_retur_jual`
  ADD PRIMARY KEY (`kode_retur_jual`);

--
-- Indeks untuk tabel `tr_retur_jual_item`
--
ALTER TABLE `tr_retur_jual_item`
  ADD PRIMARY KEY (`id_retur_jual_item`);

--
-- Indeks untuk tabel `tr_retur_jual_tmp`
--
ALTER TABLE `tr_retur_jual_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tr_si`
--
ALTER TABLE `tr_si`
  ADD PRIMARY KEY (`kode_si`);

--
-- Indeks untuk tabel `tr_si_item`
--
ALTER TABLE `tr_si_item`
  ADD PRIMARY KEY (`id_si_item`);

--
-- Indeks untuk tabel `tr_transaksi`
--
ALTER TABLE `tr_transaksi`
  ADD PRIMARY KEY (`kode_transaksi`);

--
-- Indeks untuk tabel `tr_transaksi_item`
--
ALTER TABLE `tr_transaksi_item`
  ADD PRIMARY KEY (`id_transaksi_item`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `sys_akses`
--
ALTER TABLE `sys_akses`
  MODIFY `akses_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=455;

--
-- AUTO_INCREMENT untuk tabel `sys_group`
--
ALTER TABLE `sys_group`
  MODIFY `group_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `sys_menu`
--
ALTER TABLE `sys_menu`
  MODIFY `menu_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sys_submenu`
--
ALTER TABLE `sys_submenu`
  MODIFY `submenu_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tr_harga`
--
ALTER TABLE `tr_harga`
  MODIFY `id_harga` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tr_harga_item`
--
ALTER TABLE `tr_harga_item`
  MODIFY `id_harga_item` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1658;

--
-- AUTO_INCREMENT untuk tabel `tr_pembelian_item`
--
ALTER TABLE `tr_pembelian_item`
  MODIFY `id_pembelian_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tr_penjualan_item`
--
ALTER TABLE `tr_penjualan_item`
  MODIFY `id_penjualan_item` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tr_pi_item`
--
ALTER TABLE `tr_pi_item`
  MODIFY `id_pi_item` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tr_retur_jual_item`
--
ALTER TABLE `tr_retur_jual_item`
  MODIFY `id_retur_jual_item` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tr_retur_jual_tmp`
--
ALTER TABLE `tr_retur_jual_tmp`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tr_si_item`
--
ALTER TABLE `tr_si_item`
  MODIFY `id_si_item` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tr_transaksi_item`
--
ALTER TABLE `tr_transaksi_item`
  MODIFY `id_transaksi_item` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
