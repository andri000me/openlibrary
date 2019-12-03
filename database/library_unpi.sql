-- phpMyAdmin SQL Dump
-- version 4.4.13.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Feb 2016 pada 10.10
-- Versi Server: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_unpi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE IF NOT EXISTS `anggota` (
  `kd_mem` varchar(20) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `ttl` date NOT NULL,
  `alamat` text NOT NULL,
  `fakultas` varchar(20) NOT NULL,
  `jurusan` varchar(25) NOT NULL,
  `semester` int(1) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `image` varchar(255) NOT NULL,
  `last_log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`kd_mem`, `kd_petugas`, `nama`, `nim`, `jk`, `ttl`, `alamat`, `fakultas`, `jurusan`, `semester`, `kelas`, `tlp`, `email`, `password`, `date_input`, `date_update`, `status`, `image`, `last_log`) VALUES
('a001', 'lib001', 'Ajar Surya Fitriani', '12620015', 'Pria', '1994-05-12', 'Sayang', 'Ekonomi', 'Akuntansi', 8, 'Reguler', '085722299593', 'anjar@gmail.com', 'anjarsurya', '2016-01-21', '2016-02-25', 'Aktif', 'assets/pm/a001.jpg', '2016-01-21 20:25:03'),
('f001', 'lib001', 'Fahma Eliza Farhat', '15810004', 'Wanita', '1996-01-12', 'Cianjur', 'Fikom', 'Fikom', 2, 'Reguler', '0821352678', 'fahma@gmail.com', 'fahmaeliza', '2016-01-21', '0000-00-00', 'Aktif', 'assets/pm/f001.jpg', '2016-01-21 20:28:09'),
('i001', 'lib001', 'Inka Rostini', '13610001', 'Wanita', '1994-08-26', 'Cipanas', 'Ekonomi', 'Manajemen', 6, 'Reguler', '08965786765', 'inka@gmail.com', 'inkarostini', '2016-01-21', '0000-00-00', 'Aktif', 'assets/pm/i001.jpg', '2016-01-29 08:25:59'),
('m001', 'lib001', 'M. Iqbal Ramdan', '15520022', 'Pria', '1996-03-07', 'Cikaret', 'Ekonomi', 'Akuntansi', 2, 'Reguler', '08574563216', 'iqbal@yahoo.com', 'iqbalramdan', '2016-01-21', '0000-00-00', 'Aktif', 'assets/pm/m001.jpg', '0000-00-00 00:00:00'),
('m002', 'lib001', 'Mia Ismiati', '12620004', 'Wanita', '1994-05-03', 'Cipanas', 'Ekonomi', 'Akuntansi', 8, 'Reguler', '0889123015', 'mia@gmail.com', 'miaismiati', '2016-01-21', '0000-00-00', 'Aktif', 'assets/pm/m002.jpg', '0000-00-00 00:00:00'),
('n001', 'lib001', 'Nurani Saqinah', '13620023', 'Wanita', '1995-04-04', 'Cipanas', 'Ekonomi', 'Akuntansi', 6, 'Reguler', '087867843219', 'nurani@ymail.com', 'nurani', '2016-01-21', '2016-01-29', 'Aktif', 'assets/pm/n001.jpg', '2016-01-29 17:26:27'),
('p001', 'lib001', 'Putri Fitria Rahayu', '12620007', 'Wanita', '1994-01-15', 'Cianjur', 'Ekonomi', 'Akuntansi', 8, 'Reguler', '089655321897', 'putri@gmail.com', 'putrirahayu', '2016-01-21', '2016-01-21', 'Aktif', 'assets/pm/p001.jpg', '0000-00-00 00:00:00'),
('p002', 'lib001', 'Putri Intan Wahyuni', '12620014', 'Wanita', '1994-03-26', 'Cianjur', 'Sastra', 'Sastra Inggris', 8, 'Reguler', '089678532129', 'putriwahyuni@gmail.com', 'putriintan', '2016-01-21', '2016-01-21', 'Aktif', 'assets/pm/p002.jpg', '0000-00-00 00:00:00'),
('s001', 'superadmin3006', 'Sarah', '11720027', 'Wanita', '1993-06-30', 'Jl.Selamet No. 29', 'Teknik', 'Teknik Informatika', 8, 'Reguler', '089694997568', 'yamato.kara@yahoo.com', 'sarahsiti', '2016-01-21', '0000-00-00', 'Aktif', 'assets/pm/s001.jpg', '2016-02-04 16:46:30'),
('s002', 'lib001', 'Sinta Handayani', '126100014', 'Wanita', '1994-10-14', 'cianjur', 'Ekonomi', 'Manajemen', 6, 'Reguler', '085600088932', 'sinta@gmail.com', 'sintahandayani', '2016-01-21', '2016-01-21', 'Aktif', 'assets/pm/s002.jpg', '0000-00-00 00:00:00'),
('s003', 'lib001', 'Siti Rina Febriani', '13610060', 'Wanita', '1995-05-19', 'Cianjur', 'Ekonomi', 'Manajemen', 6, 'Reguler', '08786643553', 'siti@gmail.com', 'sitirina', '2016-01-21', '2016-01-21', 'Aktif', 'assets/pm/s003.jpg', '0000-00-00 00:00:00'),
('s004', 'lib001', 'Sri Hartini', '14620029', 'Wanita', '1995-07-19', 'Warjeng', 'Ekonomi', 'Akuntansi', 4, 'Reguler', '08967758861', 'sri@ymail.com', 'srihartini', '2016-01-21', '0000-00-00', 'Aktif', 'assets/pm/s004.jpg', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `kd_buku` varchar(20) NOT NULL,
  `kd_cat` varchar(20) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  `judul` varchar(225) NOT NULL,
  `kd_pengarang` varchar(20) NOT NULL,
  `kd_penerbit` varchar(20) NOT NULL,
  `thn_terbit` int(4) NOT NULL,
  `edisi` varchar(50) NOT NULL,
  `issn_isbn` varchar(20) NOT NULL,
  `seri` varchar(50) NOT NULL,
  `abstrak` text NOT NULL,
  `kd_subjek` varchar(10) NOT NULL,
  `kd_klasifikasi` varchar(10) NOT NULL,
  `kd_sirkulasi` varchar(10) NOT NULL,
  `penerimaan` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `harga` int(6) NOT NULL,
  `stok` int(3) NOT NULL,
  `lama_pinjam` int(1) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ket` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`kd_buku`, `kd_cat`, `kd_petugas`, `judul`, `kd_pengarang`, `kd_penerbit`, `thn_terbit`, `edisi`, `issn_isbn`, `seri`, `abstrak`, `kd_subjek`, `kd_klasifikasi`, `kd_sirkulasi`, `penerimaan`, `unit`, `harga`, `stok`, `lama_pinjam`, `date_input`, `date_update`, `status`, `image`, `ket`) VALUES
('bk0001', '005.117', 'lib001', 'UML Distilled Ed.3, Panduan Singkat Bahasa Permodelan Objek Standar', 'PG0008', 'PT0006', 2005, '3', '979-731-756-0', '', 'Buku ini menjelaskan semua jenis diagram penting UML, apa saja kegunaannya dan notasi dasar yang digunakan untuk membuat dan mengartikannya. Diagram-diagram ini meliputi class, sequence, object, package, deployment, use case, state machine, activity, communication, composite structure, component, interaction overview, dan timing diagram. Contoh-contoh dalam buku ini jelas dan penjelasannya mencapai logika desain dasar.', 'SJ0007', 'ksi0004', 'SI01', 'Beli', 'Teknik', 64000, 1, 3, '2016-01-22', '2016-01-29', 'Tersedia', 'assets/bp/bk0001.jpg', '-'),
('bk0002', '604.2', 'lib001', 'Memperbaiki Windows dengan TuneUp Utilities 2008', 'PG0009', 'PT0007', 2009, '', '978-979-1078-74-0', '', 'Pada sebuah sistem komputer pasti mempunyai masalah, diantaranya adalah komputer terasa lambat sekali padahal sudah memakai memory atau RAM yang besar, windows seringkali error, atau mungkin gangguan pada aplikasi yang dipakai. Dan hal ini pasti sangat menjengkelkan bagi para pengguna komputer karena akan menghambat pekerjaan.yang berhubungan dengan komputer. Buku ini hadir untuk menjawab segala permasalahan tersebut. Buku ini menjelaskan bagaimana cara mengoptimalkan kinerja sebuah komputer yang berbasis sistem operasi windows. Dengan menggunakan bantuan TuneUp Utilities 2008, memperbaiki sistem windows terasa sangat mudah sekali. Fungsi TuneUp Utilities adalah memperbaiki sistem inti dari software computer yaitu sistem operasi. Untuk Windows XP, registry program dan program yang telah disimpan pada sistem operasi terkadang tidak bersih dibuang. Khususnya driver yang masih tertinggal, tetapi software sistem operasi tetap saja melakukan loading. Akhirnya, data yang disimpan tidak lagi dijalankan. Sayangnya pelaksanaan pada start program menjadi terganggu dan terkadang menjadikan sistem operasi melakukan loading program yang tidak perlu sehingga memperlambat sebuah PC. Buku ini secara detail membahas semua cara penggunaan program TuneUp Utilities 2008, disertai dengan pembahasan yang singkat dan jelas sehingga pembaca dapat memahami apa yang disampaikan dari buku tersebut. - See more at: http://dutailmu.co.id/product20858-memperbaiki-windows-dengan-tuneup-utilities-2008.html#popup', 'SJ0008', 'ksi0004', 'SI01', 'Beli', 'Teknik', 18000, 1, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0002.jpg', ''),
('bk0003', '511', 'lib001', 'Multimedia Digital - Dasar Teori dan Pengembangann', 'PG0010', 'PT0006', 2010, '', '978-979-29-1328-6', '', 'Pada pembahasan buku Multimedia Digital ini, pembaca akan mempelajari tentang multimedia, apa saja elemen-elemen penyusunya, teknologinya, dan bagaimana mengembangkannya dengan metodologi yang ada. Buku ini juga memperkenalkan beberapa perangkat lunak sebagai alat bantu untuk mengembangkan elemen-elemen multimedia', 'SJ0009', 'ksi0005', 'SI01', 'Beli', 'Teknik', 0, 2, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0003.jpg', ''),
('bk0004', '003.1', 'lib001', 'Sistem Operasi', 'PG0011', 'PT0008', 2005, '2', '979-957-791-8', '', 'Buku ini memuat konsep-konsep dan teknik-teknik dasar yang terdapat pada sistem operasi. Konsep-konsep dasar yang dibahas di buku ini merupakan prasyarat awal untuk pemahaman inti pokok yang terdapat pada sistem operasi. Dalam buku ini dibahas konsep-konsep pokok dari subsistem-subsistem(komponen-komponen) sistem operasi, yaitu: (1). Sekilas model sistem komputer, (2). kongkurensi, (3). manajemen memori, (4) Memori maya (virtual memory), (5). manajemen perangkat masukan/keluaran, (6). manajemen sistem file, dan(7). keamanan sistem. Penulis dalam buku ini membahas secara ringkas, lugas, namun menyeluruh terhadap konsep-konsep sangat fondamental yang harus dipahami mahasiswa dan proktisi di bidang komputer dan perangkat lunak. Contoh-contoh yang diberikan meliputi Linux dan Windows (windows 95 dan Windows NT) untuk lebih memberikan gambaran yang lebih jelas dari konsep-konsep dan teknik-teknik yang dibahas. Revisi keempat ini merupakan perbaikan dan penyempurnaan edisi-edisi sebelumnya sehingga dapat memenuhi keperluan dasar-dasar ilmu dan sistem operasi mutakhir saat ini.', 'SJ0010', 'ksi0004', 'SI01', 'Beli', 'Teknik', 0, 3, 1, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0004.jpg', ''),
('bk0005', '425', 'lib001', 'Modern English Grammar Kalf', 'PG0012', 'PT0009', 2008, '', '9786028118194', 'Jakarta', 'Modern English Grammar merupakan materi panduan dalam mempelajari bahasa tata bahasa Inggris yg baik & benar. Berisi materi pelajaran tata bahasa Inggris yg telah mengalami banyak revisi & penyempurnaan. Disamping muatan lengkap tentang materi tata bahasa Inggris, buku ini juga dilengkapi dengan complete Regular & Irregular Verbs (Kata Kerja Beraturan & Tak Beraturan Lengkap); Complete Tenses (Perubahan Bentuk Waktu Bahasa Inggris Lengkap); Complete English Synonyms & Antonyms (Persamaan & Lawan kata Bahasa Inggris Lengkap); Complete Idiom (Ungkapan bahasa Inggris Lengkap). Sesuai dengan isi materi di dalamnya, buku ini sangat sesuai digunakan oleh semua kalangan, khususnya bagi para pelajar, mahasiswa & para pembaca yg ingin mendalami & mempelajari tata bahasa Inggris dengan baik & benar.', 'SJ0011', 'ksi0006', 'SI01', 'Beli', 'Sastra', 46000, 1, 3, '2016-01-22', '2016-01-22', 'Tersedia', 'assets/bp/bk0005.jpg', ''),
('bk0006', '423', 'lib001', 'Dear John', 'PG0013', 'PT0010', 2007, '', '0446528056', '', 'Is duty enough reason to live a lie?\r\n\r\nWhen John meets Savannah, he realises he is ready to make some changes. Always the angry rebel at school, he has enlisted in the Army, not knowing what else to do with his life. Now he''s ready to turn over a new leaf for the woman who has captured his heart.\r\n\r\nWhat neither realises is that the events of 9/11 will change everything. John is prompted to re-enlist and fulfil what he feels is his duty to his country. But the lovers are young and their separation is long. Can they survive the distance?', 'SJ0012', 'ksi0007', 'SI01', 'Beli', 'Sastra', 0, 1, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0006.jpg', ''),
('bk0007', '425', 'lib001', 'Cara Praktis Menguasai 16 Tenses', 'PG0014', 'PT0011', 2009, '', '979-9051-66-5 ', '', 'In his book â€œCARA CEPAT BELAJAR 16 TENSESâ€\r\nchange the verb is one of the basic factors that need to know well in English. This is so that we can speak English both oral and writtencorrectly\r\nmerupakn tenses tense forms in English. tenses used to expresswhen an event or events occur. As for the tenses is an illustration orexplanation, when an event, incident, statements, news and action inthe sentence appropriate to the circumstances, such as: current,past, or in the future or change the form of the verb. in simple tensesof words that show the mean time, be it of an action, activity, or level of completeness.', 'SJ0013', 'ksi0008', 'SI01', 'Beli', 'Teknik', 0, 1, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0007.jpg', ''),
('bk0008', '301', 'lib001', 'Metode Penelitian Komunikasi', 'PG0015', 'PT0012', 2009, '', '9795141619', '', 'Pada buku ini penulis menjelaskan cara-cara melakukan penelitian komunikasi. Setelah menguraikan metode, model, dan teknik penelitian komunikasi, ia juga membimbing anda untuk membuat usulan penelitian, baik untuk keperluan skripsi maupun untuk ditawarkan pada lembaga pemberi dana. Buku ini dilengkapi dengan petunjuk praktis pengujian hipotesis dengan tes-tes statistik.', 'SJ0014', 'ksi0009', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0008.jpg', ''),
('bk0009', '307', 'lib001', 'Ilmu Budaya Dasar: Suatu Pengantar', 'PG0016', 'PT0013', 2005, '', '979-96055-8-x', '', 'Ilmu budaya; budaya dasar, kebudayaan', 'SJ0015', 'ksi0010', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0009.jpg', ''),
('bk0010', '310', 'lib001', 'Buku Teori Ekonomi Mikro', 'PG0017', 'PT0013', 2010, '', '979-1073-8', '', 'Sebagai salah satu buku yang banyak digunakan dalam mata kuliah Pengantar Ekonomi Mikro dan Pengantar Ekonomi Makro, penulis buku Pengantar Ekonomi Mikro ini berupaya semaksimal mungkin agar menempatkan diri sebagai orang yang pertama kali mempelajari ilmu ekonomi. Oleh karena itu, sebagai hasilnya, materi yang dibahas atau diberikan oleh buku ini dapat dikatakan lebih singkat daripada buku-buku pengantar ilmu ekonomi lainnya. Melalui penyampaian yang lebih singkat dan lebih berfokus pada penerapan dan kebijakan, buku ini dapat membantu para pembaca untuk memperoleh perspektif baru dan wawasan yang lebih luas, serta pemahaman yang lebih tepat dalam memandang dunia dari sudut pandang ekonom.', 'SJ0016', 'ksi0011', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-22', '2016-02-25', 'Tersedia', 'assets/bp/bk0010.jpg', ''),
('bk0011', '657.3', 'lib001', 'Ekonomi Koperasi', 'PG0018', 'PT0014', 2010, '', '9786028361248', '', 'Karena buku ini sangat dirasakan Manfaatnya bagi mahasiswa dan pembaca lainnya, maka penulis memberanikan diri untuk mencetak. Adapun isi materi buku terdiri dari 14 bab. Setelah mempelajari buku Ekonomi Koperasi ini, mahasiswa dan pembaca umumnya dapat memahami dan mengetahui kondisi perkoperasian dan UKM di Indonesia dengan berbagai persoalan yang di hadapi dan solusi pemecahannya baik dari sisi ekonomi dan Politik. ', 'SJ0017', 'ksi0012', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0011.jpg', ''),
('bk0012', '511', 'lib001', 'Multimedia Digital - Dasar Teori dan Pengembangann', 'PG0010', 'PT0006', 2010, '', '978-979-29-1328-6', '', 'Pada pembahasan buku Multimedia Digital ini, pembaca akan mempelajari tentang multimedia, apa saja elemen-elemen penyusunya, teknologinya, dan bagaimana mengembangkannya dengan metodologi yang ada. Buku ini juga memperkenalkan beberapa perangkat lunak sebagai alat bantu untuk mengembangkan elemen-elemen multimedia', 'SJ0009', 'ksi0005', 'SI01', 'Beli', 'Teknik', 0, 2, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0012.jpg', ''),
('bk0013', '005.117', 'superadmin3006', 'UML Distilled Ed.3, Panduan Singkat Bahasa Permode', 'PG0008', 'PT0006', 2005, '3', '979-731-756-0', '', 'Buku ini menjelaskan semua jenis diagram penting UML, apa saja kegunaannya dan notasi dasar yang digunakan untuk membuat dan mengartikannya. Diagram-diagram ini meliputi class, sequence, object, package, deployment, use case, state machine, activity, communication, composite structure, component, interaction overview, dan timing diagram. Contoh-contoh dalam buku ini jelas dan penjelasannya mencapai logika desain dasar.', 'SJ0007', 'ksi0004', 'SI01', 'Beli', 'Teknik', 64000, 1, 3, '2016-01-22', '2016-01-23', 'Hilang', 'assets/bp/bk0001.jpg', '-'),
('bk0014', '005.117', 'lib001', 'UML Distilled Ed.3, Panduan Singkat Bahasa Permode', 'PG0008', 'PT0006', 2005, '3', '979-731-756-0', '', 'Buku ini menjelaskan semua jenis diagram penting UML, apa saja kegunaannya dan notasi dasar yang digunakan untuk membuat dan mengartikannya. Diagram-diagram ini meliputi class, sequence, object, package, deployment, use case, state machine, activity, communication, composite structure, component, interaction overview, dan timing diagram. Contoh-contoh dalam buku ini jelas dan penjelasannya mencapai logika desain dasar.', 'SJ0007', 'ksi0004', 'SI01', 'Beli', 'Teknik', 64000, 1, 3, '2016-01-22', '0000-00-00', 'Tersedia', 'assets/bp/bk0001.jpg', '-'),
('bk0015', '27.988', 'lib001', 'Hukum Pajak Dilengkapi dengan Latihan Soal', 'PG0019', 'PT0015', 2002, '', '979-691-127-2', '', 'Pengadilan Pajak berpuncak pada Mahkaman Agung sesuai dengan sistem kekuasaan kehakiman. Dengan demikian meskipun keputusan pengadilan pajak adalah keputusan terakhir, maka dapat diupayakan pengajuan Peninjauan Kembali ke Mahkamah Agung. Untuk memudahkan pembaca memahami isi buku ini, penulis melengkapinya dengan latihan-latihan soal. Pembaca yang ingin memahami lebih lanjut masalah perpajakan, penulis juga telah menyusun buku perpajakan lainnya, seperti Perpajakan, Perencanaan Pajak, Panduan Ujian Sertifikasi Konsultan Pajak, dan Akuntansi Pajak.', 'SJ0018', 'ksi0013', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-29', 'Tersedia', 'assets/bp/bk0015.jpg', ''),
('bk0016', '657.40', 'lib001', 'Auditing Pemeriksaan Akuntan oleh Kantor Akuntan Publik Jilid 1', 'PG0020', 'PT0016', 2004, '3', '979-8140-65-6', '', 'Tidak ada', 'SJ0019', 'ksi0013', 'SI01', 'Donasi', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0016.jpg', 'Sumbangan Mahasiswa'),
('bk0017', '657.45', 'lib001', 'Auditing Pemeriksaan Akuntan oleh Kantor Akuntan Publik Jilid 2', 'PG0020', 'PT0017', 2004, '3', '979-8140-65-6', '', 'Tidak ada.', 'SJ0019', 'ksi0013', 'SI01', 'Donasi', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-29', 'Tersedia', 'assets/bp/bk0017.jpg', 'Sumbangan mahasiswa F.E'),
('bk0018', '657.4', 'lib001', 'Akuntansi Perpajakan', 'PG0021', 'PT0015', 2007, '1', '978-979-691-436-4', '', 'Buku Akuntansi Perpajakan Edisi 1 ini disusun berbdasarkan akun-akun utama dalam perusahaan yang di dalamnya dibahas ketentuan perpajakan yang memengaruhi pencatatan jurnal, buku besar, hingga pembuatan laporan keuangan, yang menjadi sumber utama perhitungan pajak penghasilan. Dengan demikian diharapkan pembaca mampu memahami proses pencatatan akuntansi yang baik dengan memerhatikan ketentuan perpajakan yang berlaku. Buku ini dapat digunakan sebagai buku teks mahasiswa program sarjana maupun pasca sarjana, serta menajdi buku pegangan bagi mereka yang ingin memahami konsep akuntasi perpajakan.', 'SJ0018', 'ksi0013', 'SI01', 'Donasi', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-29', 'Tersedia', 'assets/bp/bk0018.jpg', 'Sumbangan mahasiswa F.E'),
('bk0019', '657.6', 'lib001', 'Akuntansi Pemerintahan Indonesia', 'PG0022', 'PT0018', 1999, '', '979-503-278-x', '', 'Masalah kebocoran adalah masalah yang sangat seriys di dalm pengelolaan keuangan negara di Indonesia. Namun selama ini masalah itu lebih banyak disoroti aspek moralnya. Tidak banyak pihak yang menyadari bahwa masalah kebocoran --sebagai contoh persoalan kegagalan administrasi, sebenarnya lebih banyak berkaitan dengan metode pengelolaan, metode pembukuan, dan metode pengawasan keuangan negara itu sendiri. Oleh karena itu, guna meningkatkan apresiasi terhadap masalah pengelolaan, pembukuan, dan pengawasan keuangan negara tersebut, penerbitan buku yang membahas persoalan itu memang layak digalakkan.', 'SJ0020', 'ksi0014', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-29', 'Tersedia', 'assets/bp/bk0019.jpg', ''),
('bk0020', '10.109', 'lib001', 'Memahami Akuntansi Keuangan', 'PG0023', 'PT0019', 2006, '', '979-769-086-5', '', 'Buku ini memberikan pemahaman mengenai akuntansi dan prosesnya secara umum dan singkat. Selain itu, buku ini juga dilengkapi dengan akuntansi sesuai bentuk perusahaan dan jenis yang dijalankan. Dengan dasar, akuntansi, baik mahasiswa maupun pihak-pihak yang memerlukan informasi-informasi yang terdapat dalam laporan keuangan, dapat mempelajarinya dengan mudah.', 'SJ0020', 'ksi0013', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-29', 'Tersedia', 'assets/bp/bk0020.jpg', ''),
('bk0021', '10.254', 'lib001', 'Kamus Istilah Akuntansi', 'PG0024', 'PT0020', 1994, '', '979-637-115-4', '', 'Kamus ini menyediakan dan menguraikan berbagai definisi, contoh dan gambaran dari segenap bidang akuntansi antara lain akuntansi keuangan, pengelolaan  dan akuntansi biaya, audit, analisis laporan keuangan, serta pajak. Termasuk di antaranya istilah-istilah penting di bidang keuanga, operations research dan metode kuantitatif, komputer serta ekonomi. Kamus ini sangan komunikatif dan mudah dipahami', 'SJ0021', 'ksi0015', 'SI01', 'Donasi', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-29', 'Tersedia', 'assets/bp/bk0021.jpg', 'Sumbangan mahasiswa F.E\r\n'),
('bk0022', '457', 'lib001', 'Practice Case for Auditing', 'PG0025', 'PT0021', 1986, '', '0-02-423990-9', '', 'Tidak ada', 'SJ0020', 'ksi0015', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0022.jpg', ''),
('bk0023', '10.663', 'lib001', 'Sistem Komunikasi Indonesia', 'PG0026', 'PT0019', 2008, '', '979-421-995-9', '', 'Buku ini memberikan gambaran mengenai  bentuk sistem komunikasi di Indonesia dengan uraian-uraiannya mengenai sistem pers Indonesia, sistem komunikasi di pedesaan, peranan opinion leader di Indonesia, dan fenomena ponsel dalam sistem komunikasi Indonesia. Dilatarbelakangi oleh kebijakan kurikulum nasional yang mencantumkan mata kuliah SKI yang berdiri sendiri, pemunculan buku ini dimaksudkan juga untuk mengisi kelangkaan literatur mengenai Sistem Komunikasi Indonesia', 'SJ0022', 'ksi0016', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0023.jpg', ''),
('bk0024', '10.685', 'lib001', 'Etika Kehumasan Konsepsi & Aplikasi', 'PG0027', 'PT0019', 2008, '', '979-421-847-2', '', 'Etika kehumasan adalah panduan etis bagi para profesionalitas di bidang ini. Ada banyak pronsip yang terkandung di dalamnya yang harus diketahui dan dipahami dengan baik oleh para profesional. Buku ini membeberkan secara sistematis prinsi-prinsip utama etika kehumasan profesional. Pemabhasan yang dituangkan dalam buku ini sangat luas, mulai dari sisi dasar dan filosofis dari etika dan komunikasi sampai pada apliaksi etika profesional. Oleh karena itu, buku ini menjadi bacaan wajib bagi siapa saja yang ini menjadi profesional humas (PR) yang etis dan bertanggung jawab.', 'SJ0023', 'ksi0017', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0024.jpg', ''),
('bk0025', '10.656', 'lib001', 'Sosiologi Komunikasi Massa', 'PG0028', 'PT0022', 1959, '', '979-514-229-1', '', 'Tidak ada.', 'SJ0024', 'ksi0016', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0025.jpg', ''),
('bk0026', '302.2', 'lib001', 'Dimensi Dimensi Komunikasi', 'PG0029', 'PT0023', 1986, '', '979-414-016-3', '', 'Buku ini mengantarkan khayalayk ke arah pemahaman komunikasi yang begitu luas dan rumit, untuk dapat kiranya menunjang kepemimpinan mereka, baik yang bakal maupun yang sudah menjadi pemimpin.', 'SJ0022', 'ksi0016', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0026.jpg', ''),
('bk0027', '10.660', 'lib001', 'Antropologi', 'PG0030', 'PT0024', 1985, '', '62-10-042-5', '', 'Tidak ada.', 'SJ0025', 'ksi0009', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0027.jpg', ''),
('bk0028', '10.239', 'lib001', 'Komunikasi Propaganda', 'PG0026', 'PT0022', 2001, '', '979-692-109-x', '', 'Buku ini akan mencapai sasarannya jika pembaca menjadi lebih paham tentang esensi propaganda dan menggunakannya untuk kegiatan positif. Untuk itu pulalah berbagai contoh propaganda yang pernahditerapkan di Indonesia dikemukakan dalam buku ini. Para mahasiswa sangat dianjurkan untuk memahami propaganda. Buku ini juga bermanfaat bagi para aktivis politik, pengambilan kebijakan politik dari praktisi komunikasi.', 'SJ0026', 'ksi0018', 'SI01', 'Donasi', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0028.jpg', 'Sumbagan dari Kopertis Wil IV Bandung'),
('bk0029', '302', 'lib001', 'Ilmu Komunikasi Suatu Pengantar', 'PG0031', 'PT0022', 2010, '', '979-514-993-8', '', 'Tidak ada.', 'SJ0027', 'ksi0019', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0029.jpg', ''),
('bk0030', '004', 'lib001', 'Prosedur Penelitian Suatu Pendekatan Praktik', 'PG0032', 'PT0025', 2006, 'Edisi Revisi VI', '979-518-018-5', '', 'Buku ini merupakan revisi dari buku Prosedur Penelitian Edisi revisi V. Di dalamnya telah disesuaikan dengan perkembangan ilmu. Agak berbeda dengan buku-buku Metodologi Riset yang telah ada, buku ini disajikan sesuai dengan urutan langkah dalam mengadakan penelitian. Oleh karena langkah penelitian yang membentuk pola ini pun bervariasi menurut pendapat orang yang berbeda, maka penulis sebut dengan salah pola.', 'SJ0028', 'ksi0020', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0030.jpg', ''),
('bk0031', '10.203', 'lib001', 'Pengantar Bisnis', 'PG0033', 'PT0026', 2000, '', '979-655-850-5', '', 'Buku ini memaparkan secara mendekati tentang: Konsep bisnis dan ilmu ekonomi perusahaan di era globalisasi, kewiraswastaan dan perusahaan kecil, bentuk-bentuk badan usaha, manajemen dan organisasi, pemasaran, produksi, akuntansi biaya dan harga pokok, analisis break even point, konsep nilai waktu dari uang, dan manajemen keuangan perusahaan. Pemaparan dengan berbagai contoh kasus dalam buku ini jelas akan sangat membantu siapa pun yang telah atau akan terjun dalam bisnis.', 'SJ0029', 'ksi0011', 'SI01', 'Donasi', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0031.jpg', 'Sumbangan dari Kopertis Wil IV Bandung'),
('bk0032', '10.223', 'lib001', 'Dasar-Dasar Manajemen Produksi dan Operasi', 'PG0034', 'PT0018', 2000, '1', '979-503-286-0', '', 'Tidak ada.', 'SJ0030', 'ksi0017', 'SI01', 'Donasi', 'Teknik', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0032.jpg', 'Sumbangan dari Kopertis Wil. IV Bandung'),
('bk0033', '10.214', 'lib001', 'Teknik Proyeksi Bisnis Teori dan Aplikasi dengan Microsof Excel', 'PG0035', 'PT0006', 2008, '', '978-979-29-0347-8', '', 'Buku ini berisi teknik-teknik proyeksi bisnis yang bersifat kuantitatif maupun proyeksi bisnis yang bersifat kualitatif. Untuk memudahkan pembaca dalam memahami teknik proyeksi bisnis , buku ini disusun secara sistematis, singkat dan jelas. Untuk pemecahan proyeksi bisnis kuantitatif diguankan Microsoft Excel. Dengan bantuan program ini pembaca dapat mempraktikan setiap langkah penyusunan proyeksi bisnis sehingga tidak hanya sekedar mahir dalam memberikan interpretasi output tetapi juga memahami asal nilai-nilai yang ada pada output akhir program komputer', 'SJ0031', 'ksi0004', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0033.jpg', ''),
('bk0034', '650.1', 'lib001', 'Manajemen Keuangan Berbasis Balance Scorecard Pendekatan Teori, Kasus, dan Riset Bisnis', 'PG0036', 'PT0027', 2009, '', '978-979-010-504-1', '', 'Buku manajemen keuangan ini dirancang berdasarkan road-map teori-teori keuangan yang eligible, disusun secara kronologis dan terpadu dalam kerangka empat perspektif pengelolaan, yaitu perspektif keuangan, proses bisnis internal, learning and growth perspective (MSDM), dan kefokusan pada langganan, atau disebut sebagai "Manajemen Keuangan Berbasis Balanced Scorecard (BSC)".', 'SJ0032', 'ksi0021', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0034.jpg', ''),
('bk0035', '10.237', 'lib001', 'Manajemen Penerbitan Pers', 'PG0037', 'PT0022', 2004, '', '979-692-003-4', '', 'Buku ini akan mengantar kita kepada pengetahuan praktis sebagai persiapan awal mengelola penerbitan pers. Lewat penelitian Drs. Totok Djuroto, M. Si., seorang pengajar di STIKOSA-AWS Surabaya dan seorang peneliti muda pada Balai Penelitian Pers dan Pendapat Umum Surabaya, memberikan kajian praktis yang akan berguna bagi para praktisi pemula penerbitan pers, selain tentu saja para mahasiswa (Komunikasi, khususnya) peserta mata kuliah Manajemen Media Massa, Manajemen Surat Kabar, atau sejenisnya.', 'SJ0033', 'ksi0022', 'SI01', 'Donasi', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0035.jpg', 'Sumbangan dari Kopertis Wil. IV Bandung'),
('bk0036', '338.5', 'lib001', 'Teori Ekonomi Mikro', 'PG0017', 'PT0028', 2007, '', '979--1073-80-5', '', 'Buku ini adalah sebuah pijakan untuk mengkaji lebih dalam pelbagai perihal penting yang melingkari permasalahan ekonomi. Sebuah pembahasan yang mestinya menjadi bacaan wajib bagi kalangan akademisi maupun praktisi di bidang ekonomi, khususnya tentang kajian ekonomi mikro. Keunggulan buku ini paling tidak terletak pada fakta bahwa pembaca, oleh sang penulis, dituntun secara sistematis, ringkas, juga sederhana, dalam memahami persoalan ekonomi mikro.', 'SJ0034', 'ksi0011', 'SI01', 'Beli', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0036.jpg', ''),
('bk0037', '330.1', 'lib001', 'Ekonomi Moneter Buku 1', 'PG0038', 'PT0018', 1993, '4', '979-503-048-5', '', 'Tidak ada.', 'SJ0035', 'ksi0023', 'SI01', 'Donasi', 'Ekonomi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0037.jpg', 'Sumbangan Mahasiswa Akuntansi 1999'),
('bk0038', '422', 'lib001', 'Basic English Grammar Second Edition', 'PG0039', 'PT0029', 1996, '2', '0-13-368317-6', '', 'Tidak ada.', 'SJ0036', 'ksi0024', 'SI01', 'Donasi', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0038.jpg', 'Sumbangan mahasiswa F.S UNPI'),
('bk0039', '10.736', 'lib001', 'Basic English Grammar Third Edition', 'PG0040', 'PT0030', 2006, '3', '0-13-195734-1', 'with Answer Key', 'Tidak ada.', 'SJ0036', 'ksi0024', 'SI01', 'Beli', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0039.jpg', ''),
('bk0040', '832', 'lib001', 'The Book of Luck', 'PG0041', 'PT0031', 2004, '', '1-84112-635-7', '', 'The Book of Luck is a must-read for those who want to move up in the world. It is crammed full of practical tips on how to turn the tide of your luck.', 'SJ0037', 'ksi0007', 'SI01', 'Beli', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0040.jpg', ''),
('bk0041', '303', 'lib001', 'Meraih Passive Income dari Menulis', 'PG0042', 'PT0032', 2008, '', '978-979-180002-0-4', '', 'Bila Anda belum yakin bahwa MENULIS bisa menjadi salah satu cara memperoleh PASSIVE INCOME, maka Anda wajib membaca buku ini. Sebab di dalamnya banyak diberikan motivasi dan inspirasi bagaimana caranya memperoleh passive income dari kegiatan menulis', 'SJ0038', 'ksi0025', 'SI01', 'Beli', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0041.jpg', ''),
('bk0042', '10.743', 'lib001', 'Pengajaran Sintaksis', 'PG0043', 'PT0033', 2009, '', '978-979-665-611-7', '', 'Tidak ada.', 'SJ0039', 'ksi0026', 'SI01', 'Beli', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0042.jpg', ''),
('bk0043', '928', 'lib001', 'Ensiklopedia Tokoh Sastra Indonesia', 'PG0044', 'PT0034', 2007, '1', '979-3955-43-9', '', 'Tidak ada.', 'SJ0040', 'ksi0027', 'SI01', 'Beli', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0043.jpg', ''),
('bk0044', '10.441', 'lib001', 'Everyman Essays And Poems', 'PG0045', 'PT0035', 1995, '', '0-460-87677-5', '', 'A unique paperback edition, with introduction and chronology of Emerson''s life and times.', 'SJ0037', 'ksi0028', 'SI01', 'Donasi', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0044.jpg', 'Donasi Mahasiswa F.S UNPI'),
('bk0045', '10.244', 'lib001', 'Essential Grammar in Use With Answer', 'PG0046', 'PT0036', 1997, '2', '0-521-55928-6', '', 'Essential Grammer in Use ia a grammar reference and practice book for elementary learners. Modelled on Roymond Murphy''s highly successful intermedeiate level English Grammar in Use, it concentrates on areas of grammar normally taught at elementary level.', 'SJ0013', 'ksi0029', 'SI01', 'Donasi', 'Sastra', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0045.jpg', 'Sumbangan dari Kopertis Wil. IV Bandung'),
('bk0046', '10.631', 'lib001', 'Interaksi Manusia dan Komputer', 'PG0047', 'PT0006', 2007, '', '978-979-29-0194-8', '', 'Buku ini disusun untuk memberikan pemahaman bagaimana manusia sebagai sumber daya terpenting dalam membangun sistem. Materi yang dibahas meliputi manusia, komputer, interaksi, paradigma dan prinsip penggunaan, proses desain, model kognitif, analisis tugas, desain dan notasi dialog, model sistem, dukungan implementasi, teknik evaluasi, bantuan dan dokumentasi, groupware, teori dan permasalahan pekerjaan bersama yang didukung komputer, serta sistem banyak sensor', 'SJ0041', 'ksi0030', 'SI01', 'Beli', 'Teknik', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0046.jpg', ''),
('bk0047', '10.230', 'superadmin3006', 'Perancangan Sistem Operasi', 'PG0048', 'PT0006', 2005, '', '979-731-543-6', '', 'Melalui buku ini, penulis memberi teori perancangan sistem operasi 32 bit protected mode yang di dalamnya disertai listing program yang ditulis secara lengkap menggunakan bahasa C dan Assembly sebagai contoh. Lewat buku ini pula, penulis mengajak Anda mengetahui lebih jau bagaimana sistem operasi bekerja agar Anda menemukan kemudahan saat merancang program aplikasi. Buku ini tidak membahas cara mengoperasikan sistem operasi, melainkan membahas bagaimana merancang dan membuat sendiri sebuah sistem operasi pada processor intel dan kompatibelnya.', 'SJ0042', 'ksi0004', 'SI01', 'Donasi', 'Teknik', 0, 1, 3, '2016-01-25', '0000-00-00', 'Tersedia', 'assets/bp/bk0047.jpg', 'Sumbangan Kopertis Wil. IV Bandung'),
('bk0048', '005.133', 'lib001', 'Bertualang dengan Struktur Data di Planet Pascal', 'PG0049', 'PT0037', 2005, '2', '979-756-066-7', '', 'Buku ini menjelaskan secara rinci langkah-langkah sort (pengurutan), pembuatan pointer, linked list, stack, queque, dan tree yang banyak menggunakan gambar guna memvisualisasikan dan memperjelas cara kerjanya. Selain itu pada buku ini juga banyak disertai contoh-contoh dan latihan soal yang dapat langsung dipraktekkan oleh pembaca sekalian. Juga disertai bonus soal-soal lomba pemrograman, serta soal persiapan seleksi Tim Olimpiade Komputer Indonesia', 'SJ0043', 'ksi0004', 'SI01', 'Donasi', 'Teknik', 0, 1, 3, '2016-01-25', '2016-01-29', 'Tersedia', 'assets/bp/bk0048.jpg', 'Sumbangan Mahasiswa M.I UNPI'),
('bk0049', '425', 'lib001', 'Modern English Grammar Kalf', 'PG0012', 'PT0009', 2008, '', '9786028118194', 'Jakarta', 'Modern English Grammar merupakan materi panduan dalam mempelajari bahasa tata bahasa Inggris yg baik & benar. Berisi materi pelajaran tata bahasa Inggris yg telah mengalami banyak revisi & penyempurnaan. Disamping muatan lengkap tentang materi tata bahasa Inggris, buku ini juga dilengkapi dengan complete Regular & Irregular Verbs (Kata Kerja Beraturan & Tak Beraturan Lengkap); Complete Tenses (Perubahan Bentuk Waktu Bahasa Inggris Lengkap); Complete English Synonyms & Antonyms (Persamaan & Lawan kata Bahasa Inggris Lengkap); Complete Idiom (Ungkapan bahasa Inggris Lengkap). Sesuai dengan isi materi di dalamnya, buku ini sangat sesuai digunakan oleh semua kalangan, khususnya bagi para pelajar, mahasiswa & para pembaca yg ingin mendalami & mempelajari tata bahasa Inggris dengan baik & benar.', 'SJ0011', 'ksi0006', 'SI01', 'Beli', 'Sastra', 46000, 1, 3, '2016-01-22', '2016-01-22', 'Tersedia', 'assets/bp/bk0049.jpg', ''),
('bk0050', '302.2', 'lib001', 'Dimensi Dimensi Komunikasi', 'PG0029', 'PT0023', 1986, '', '979-414-016-3', '', 'Buku ini mengantarkan khayalayk ke arah pemahaman komunikasi yang begitu luas dan rumit, untuk dapat kiranya menunjang kepemimpinan mereka, baik yang bakal maupun yang sudah menjadi pemimpin.', 'SJ0022', 'ksi0016', 'SI01', 'Beli', 'Ilmu Komunikasi', 0, 1, 3, '2016-01-25', '2016-01-30', 'Tersedia', 'assets/bp/bk0050.jpg', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pinjam`
--

CREATE TABLE IF NOT EXISTS `detail_pinjam` (
  `kd_pinjam` varchar(20) NOT NULL,
  `kd_buku` varchar(20) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_hrs_kem` date NOT NULL,
  `tgl_kem` date NOT NULL,
  `denda` int(6) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_pinjam`
--

INSERT INTO `detail_pinjam` (`kd_pinjam`, `kd_buku`, `tgl_pinjam`, `tgl_hrs_kem`, `tgl_kem`, `denda`, `status`) VALUES
('201601230001', 'bk0006', '2016-01-23', '2016-01-26', '2016-01-28', 1000, 'dikembalikan'),
('201601230001', 'bk0007', '2016-01-23', '2016-01-26', '2016-01-28', 1000, 'dikembalikan'),
('201601230001', 'bk0010', '2016-01-23', '2016-01-26', '2016-01-28', 1000, 'dikembalikan'),
('201601270001', 'bk0001', '2016-01-27', '2016-01-30', '0000-00-00', 0, 'dipinjam'),
('201601280001', 'bk0018', '2016-01-28', '2016-02-01', '0000-00-00', 0, 'dipinjam'),
('201601280001', 'bk0019', '2016-01-28', '2016-02-01', '0000-00-00', 0, 'dipinjam'),
('201601280001', 'bk0027', '2016-01-28', '2016-02-01', '0000-00-00', 0, 'dipinjam'),
('201602220001', 'bk0007', '2016-02-22', '2016-02-25', '0000-00-00', 0, 'dipinjam'),
('201602220001', 'bk0039', '2016-02-22', '2016-02-25', '0000-00-00', 0, 'dipinjam'),
('201602220001', 'bk0040', '2016-02-22', '2016-02-25', '0000-00-00', 0, 'dipinjam'),
('201602220002', 'bk0011', '2016-02-22', '2016-02-25', '0000-00-00', 0, 'dipinjam'),
('201602220002', 'bk0036', '2016-02-22', '2016-02-25', '0000-00-00', 0, 'dipinjam'),
('201602220002', 'bk0037', '2016-02-22', '2016-02-25', '0000-00-00', 0, 'dipinjam'),
('201602220003', 'bk0032', '2016-02-22', '2016-02-25', '0000-00-00', 0, 'dipinjam'),
('201602250001', 'bk0010', '2016-02-25', '2016-02-29', '0000-00-00', 0, 'dipinjam'),
('201602250001', 'bk0016', '2016-02-25', '2016-02-29', '0000-00-00', 0, 'dipinjam'),
('201602250001', 'bk0030', '2016-02-25', '2016-02-29', '0000-00-00', 0, 'dipinjam');

--
-- Trigger `detail_pinjam`
--
DELIMITER $$
CREATE TRIGGER `total` AFTER INSERT ON `detail_pinjam`
 FOR EACH ROW begin update `peminjaman` 
set jml_buku = jml_buku + 1 
where kd_pinjam = new.kd_pinjam; 
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `download_ebook`
--

CREATE TABLE IF NOT EXISTS `download_ebook` (
  `kd_ebook` varchar(100) NOT NULL,
  `last_download` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hits` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `download_ebook`
--

INSERT INTO `download_ebook` (`kd_ebook`, `last_download`, `hits`) VALUES
('BK19287.', '2016-01-09 00:57:15', 5),
('BK19287.0001', '2016-01-09 00:57:37', 1),
('BK19287.2', '2016-01-08 15:02:23', 1),
('BK19287.2.01', '2016-01-09 00:19:22', 12),
('BK19287.2.88', '2016-01-09 00:03:46', 1),
('EB00003', '2016-02-25 04:17:51', 2),
('eb00004', '2016-01-09 01:10:38', 1),
('ej0001', '2016-01-14 07:49:30', 1),
('ej0002', '2016-01-29 01:28:59', 1),
('kp0002', '2016-02-25 04:12:16', 1),
('skp0001', '2016-02-25 04:24:10', 2),
('sp0002', '2016-01-29 01:26:59', 1),
('upload_file/BK19287.2.01.pdf', '2016-01-08 12:11:51', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ebook`
--

CREATE TABLE IF NOT EXISTS `ebook` (
  `kd_ebook` varchar(20) NOT NULL,
  `kd_buku` varchar(20) NOT NULL,
  `kd_pustakawan` varchar(20) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `size` varchar(10) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ebook`
--

INSERT INTO `ebook` (`kd_ebook`, `kd_buku`, `kd_pustakawan`, `judul`, `size`, `ext`, `date_input`, `date_update`, `lokasi`) VALUES
('eb00001', 'bk0016', 'lib001', 'Daftar Isi', '598146', 'pdf', '2016-02-22', '0000-00-00', 'upload_file/eb00001.pdf'),
('eb00003', 'bk0006', 'lib001', 'Cover', '126344', 'pdf', '2016-02-25', '0000-00-00', 'upload_file/eb00003.pdf'),
('eb00004', 'bk0010', 'lib001', 'Cover', '381461', 'pdf', '2016-02-25', '0000-00-00', 'upload_file/eb00004.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE IF NOT EXISTS `jurnal` (
  `kd_jurnal` varchar(20) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kd_penulis` varchar(20) NOT NULL,
  `kd_penerbit` varchar(20) NOT NULL,
  `kd_klasifikasi` varchar(20) NOT NULL,
  `kd_subjek` varchar(20) NOT NULL,
  `thn_terbit` int(4) NOT NULL,
  `issn_isbn` varchar(20) NOT NULL,
  `jurusan` varchar(25) NOT NULL,
  `abstrak` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `file` varchar(255) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`kd_jurnal`, `kd_petugas`, `judul`, `kd_penulis`, `kd_penerbit`, `kd_klasifikasi`, `kd_subjek`, `thn_terbit`, `issn_isbn`, `jurusan`, `abstrak`, `status`, `date_input`, `date_update`, `file`, `ket`) VALUES
('ej0001', 'lib001', 'SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN JURUSAN PADA SEKOLAH MENENGAH KEJURUAN (SMK) NEGERI 1 SIATAS BARITA DENGAN METODE SIMPLE ADDITIVE WEIGHTING (SAW)', 'PG0004', 'PT0002', 'ksi0001', 'SJ0004', 2014, '2339-210X', 'Teknik Informatika', 'Penggunaan Sistem Pendukung Keputusan (SPK) dapat membantu seseorang dalam mengambil keputusan\r\nyang akurat dan tepat sasaran. Banyak permasalahan yang dapat diselesaikan dengan menggunakan SPK,\r\nsalah satunya adalah untuk menganalisis pemilihan jurusan. Metode yang dapat digunakan untuk Sistem\r\nPendukung Keputusan ini adalah dengan menggunakan Simple Additive Weighting (SAW).\r\nDalam menentukan penerima santunan yayasan, banyak sekali kriteria-kriteria yang harus dimiliki oleh\r\nindividu sebagai syarat dalam mendapatkan santunan yayasan. Yayasan pasti memiliki kriteria-kriteria untuk\r\nmenentukan siapa yang akan terpilih untuk menerima santunan yayasan periode tahunan dengan tujuan untuk\r\nmembantu seseorang yang kurang mampu ataupun berprestasi selama menempuh studinya.\r\nPada penelitian ini akan diangkat suatu kasus yaitu mencari alternative terbaik berdasarkan kriteriakriteria\r\nyang telah ditentukan oleh yayasan dengan menggunakan metode SAW (Simple Additive Weighting).\r\nPenelitian dilakukan dengan mencari nilai bobot untuk setiap atribut, kemudian dilakukan proses perankingan\r\nyang akan menentukan alternatif yang optimal, yaitu siswa yang tepat mendapatkan santunan yayasan.\r\nKata kunci : Sistem Pendukung Keputusan, Penerima santunan, Simple Adiditive Weigting (SAW), nilai bobot.', 'Tersedia', '2016-01-21', '0000-00-00', 'upload_file/ej0001.pdf', ''),
('ej0002', 'lib001', 'Aplikasi Model Sistem Keamanan Jaringan Berbasis De-Militarised Zone', 'PG0005', 'PT0003', 'ksi0004', 'SJ0005', 2009, '', 'Teknik Informatika', 'De-Militarized Zone (DMZ) is a "sacrificial lamb" for hackers applied to protect internal system relating to\r\nhack attack (hack attack). DMZ works for all service base of network requiring access to network "external\r\nworld" to part of network the other. That way, all " open port" is relating to external world will stay at\r\nnetwork, so that if a hacker did attack and does crack at server using system DMZ, the hacker will only can\r\naccess its(the host is only, not at internal network. In General DMZ is built based on three fruit of concept,\r\nthat is: NAT (Network Address Translation), PAT (Port Addressable Translation), and Access List. NAT\r\nfunctions to show again coming packages "real address" to internal address. For example: if wes own "real\r\naddress" 203.8.90.100, we can form a direct NAT automatically at data coming to 192.168.100.1 (an internal\r\nnetwork address). Then PAT functions menunjukan data to coming at particular port, or range a port and\r\nprotocol (TCP/UDP or other) and address IP to a particular port or range a port to an internal address of\r\nIP. While access list functions to control in precise what is coming and going out from network in a question.\r\nFor example: we can refuse or enables all ICMP is coming to all address IP except for an undesirable ICMP.\r\nKeywords: NAT, real address, PAT, Access List, Port, Protocol, DMZ, ICMP', 'Tersedia', '2016-01-21', '2016-01-29', 'upload_file/ej0002.pdf', ''),
('ej0003', 'lib001', 'SISTEM PAKAR MENDIAGNOSA PENYAKIT MANDUL PADA PRIA DAN WANITA DENGAN MENGGUNAKAN CERTAINTY FACTOR BERBASIS WEB', 'PG0006', 'PT0004', 'ksi0001', 'SJ0001', 2014, '2301-9425', 'Teknik Informatika', 'Sistem pakar (expert system) secara umum adalah sistem yang berusaha mengadopsi pengetahuan\r\nmanusia ke komputer agar komputer dapat menyelesaikan masalah seperti yang biasa dilakukan oleh para\r\nahlikemandulan memang merupakan persoalan serius yang cukup menakutkan bagi pasangan suami istri.\r\nApalagi, ketika mereka belum juga dikaruniai seorang anak dari hasil perkawinannya. Mereka dapat diketahui\r\nmemiliki tanda-tanda kemandulan apabila sang istri belum juga hamil dalam tenggang waktu tertentu dari\r\npernikahannya. Kemandulan atau yang dalam bahasa kedokterannya dikenal dengan istilah infertilitas adalah\r\nkondisi menunjukkan tidak terdapatnya pembuahan dalam waktu satu tahun setelah melakukan hubungan\r\nseksual tanpa perlindungan kontrasepsi .\r\nDiharapkan dengan sistem ini, para pria dan wanita dapat menyelesaikan masalah tertentu baik sedikit\r\nrumit ataupun rumit sekalipun tanpa bantuan para ahli dalam bidang tersebut. Sedangkan bagi para ahli, sistem\r\nini dapat digunakan sebagai asisten yang berpengalaman. Aplikasi yang dikebangkan ini bertujuan untuk\r\nmenentukan jenis gangguan pada pria dan wanita yang terkena penyakit mandul mulai dari usia 21 tahun ke\r\natas dengan hanya memperhatikan gejala-gejala yang dialami.\r\nDengan menggunakan metode certainty factor (CF), didapatkan nilai kemungkinan seseorang terkena\r\npenyakit mandul atau tidak. Metode certainty factor sangat bermanfaat untuk sistem pakar penyakit mandul.\r\nKata Kunci : Sistem Pakar, Mandul, Certainty Factor, Web.', 'Tersedia', '2016-01-21', '0000-00-00', 'upload_file/ej0003.pdf', ''),
('ej0004', 'lib001', 'Evaluasi Implementasi Keamanan Jaringan Virtual Private Network (VPN) (Studi Kasus Pada CV. Pangestu Jaya)', 'PG0007', 'PT0005', 'ksi0004', 'SJ0006', 2012, '', 'Teknik Informatika', 'CV. Pangestu Jaya yang bergerak di bidang pengadaan barang dan jasa serta software\r\nhouse, dalam pengiriman data penting perusahaan, antara kantor pusat dengan kantor cabang di\r\nkota lain secara online menggunakan jaringan VPN. Penelitian ini dilakukan dengan skenario uji\r\nkelayakan berdasarkan kebutuhan user. Pengujian-pengujian yang dilakukan adalah Pengujian\r\nKonektivitas, Pengujian Transfer Data, Attacking VPN dengan DoS (Denial Of Services), Hacking\r\nVPN dengan ARP Poisoning di Linux Backtrack. Hasil eksperimen pengujian attacking dengan\r\nDenial of Service (DoS) menggunakan tool pingflood ternyata berhasil mematikan service/layanan\r\npada VPN server. Selain itu pengujian hacking / ARP Poisoning untuk mendapatkan username dan\r\npassword dengan menggunakan tools yang ada pada Linux backtrack juga berhasil menembus\r\nakses login client ke server.\r\nKata kunci : vpn, attacking, poisoning, hacking, konektivitas.', 'Tersedia', '2016-01-21', '0000-00-00', 'upload_file/ej0004.pdf', ''),
('ej0005', 'lib001', 'Sikap Mahasiswa Program S1 Sastra Inggris, Fakultas Sastra, Universitas Airlangga Terhadap Aksen Bahasa Inggris Amerika dan Britania', 'PG0052', 'PT0038', 'ksi0029', 'SJ0045', 2005, '', 'Sastra Inggris', 'Hasil studi Ryan dan Giles (1982) menunjukkan bahwa aksen tertentu\r\ndapat mengubah pendapat publik dan menunjukkan kelas sosial seseorang. Dalam\r\nstudi tersebut, empat kelompok masyarakat diminta mendengarkan rekaman kaset\r\nmengenai capital punishment â€˜penjatuhan hukumanâ€™. Kelompok pertama\r\nmendengarkan argumen yang dilafalkan dengan aksen Received Pronunciation\r\nâ€˜pengucapan bakuâ€™ (RP); kelompok kedua mendengarkannya dalam aksen South\r\nWales; kelompok ketiga dengan aksen Somerset; dan kelompok keempat dengan\r\naksen Birmingham. Hasilnya menunjukkan bahwa para responden menilai penutur\r\nyang menggunakan aksen RP memiliki kompetensi yang lebih tinggi daripada\r\npenutur yang menggunakan aksen lokal. Akan tetapi, para responden cenderung\r\nsetuju dengan argumen penutur yang menggunakan aksen regional. Dengan\r\ndemikian, aksen regional tampaknya lebih tepat untuk mengubah pendapat\r\nmasyarakat regional.', 'Tersedia', '2016-01-29', '0000-00-00', 'upload_file/ej0005.pdf', ''),
('ej0006', 'lib001', 'PENGARUH MASA PENUGASAN KANTOR AKUNTAN PUBLIK, KEPEMILIKAN MANAJERIAL, DAN UKURAN KANTOR AKUNTAN PUBLIK TERHADAP KUALITAS LABA', 'PG0061', 'PT0046', 'ksi0015', 'SJ0054', 2012, '', 'Akuntansi', 'Earnings information which reported in a financial report is generally important, especially those who are using\r\nfinancial statements for a contract and decision making of investments. In the purpose of the contractâ€™s perspective,\r\nearnings information can be used as basis in determining the salary alocation of an enterprise. In decision making\r\ninvestmentâ€™s perspective, earnings information important for investors to know more about the condition of a\r\ncorporation so they became convinced to invest, therefore earnings profit information in the financial report of the\r\ncompany shall be qualified and in accordance with the accounting standard. This research aims to analyze the factors\r\nthat affect the quality of earnings on manufacturing companies listed on the Indonesian Stock Exchange period 2006-\r\n2010, those factors are the assignment period of public accounting, managerial ownership percentage, and size of\r\nperiod public accounting. Hypothesis testing in this research is multiple linear regressions. The results of this research\r\nindicates that the managerial ownership and public accounting size have positiveeffect on earning quality, means that\r\nthe greater the percentage of managerial ownership, and the size of a public accounting firrm indicates that the earning\r\ninformation reported in the financial statements are more qualified. The assignment period of accountant public\r\nshowed negative effect on earning quality, therefore the length the assignmentperiod of public accounting on an\r\nenterprise''s information led to the earnings information in the financial statementsworst.\r\nKeywords: Quality Of Earnings, The Assignment Period Of Public Accounting, Managerial Ownership, And The Size\r\nOf The Public Accounting', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/ej0006.pdf', ''),
('ej0007', 'lib001', 'ANALISIS FAKTOR-FAKTOR YANG MEMPENGARUHI EARNINGS RESPONSE COEFFICIENT (ERC): STUDI PADA PERUSAHAAN PROPERTI DAN REAL ESTATE YANG TERDAFTAR DI BURSA EFEK INDONESIA', 'PG0062', 'PT0048', 'ksi0037', 'SJ0056', 2011, '1410 - 1831', 'Akuntansi', 'This research is purposed to examine the influence of capital structure, growing chance, company size,\r\nsystematic risk to earning response coefficient (ERC). This research take all of company listed on\r\nIndonesia Stock Exchange as a population and property and real estate industry listed on 2004 â€“\r\n2008 period as a sample. Sample selected from property and real estate industry are those who issues\r\nthe financial statement from 2004 â€“ 2008 period based on criteria determined.\r\nThis research use secondary data as research data. This research applies double linear regression to\r\nanalyze and test t, test f and determination coefficient to test the hypothesis. This research takes\r\nleverage, beta, market-to-book value ratio, and firm size as independent variable and dependent\r\nvariable is Earning Response Coefficient (ERC). The result shows that: (1) this research\r\nhypothetically finds that beta and market-to-book ratio is statistically significant to Earning Response\r\nCoefficient (ERC), (2) this research hypothetically finds that leverage and size is not statistically\r\nsignificant to Earning Response Coefficient (ERC).\r\nKeyword: earnings response coefficient, leverage, beta, market to book value ratio, firm size', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/ej0007.rar', ''),
('ej0008', 'lib001', 'PENGARUH KOMPENSASI, LINGKUNGAN KERJA DAN PROMOSI JABATAN TERHADAP KEPUASAN KERJA', 'PG0063', 'PT0049', 'ksi0038', 'SJ0057', 2016, '2302-8912', 'Manajemen', 'Perusahaan Telkom mengalami masalah pada kepuasaan karyawannya mulai dari insetif\r\nyang kurang, tempat kerja yang kurang nyaman hingga masalah kenaikan jabatan\r\nkaryawan. Tujuan penelitian adalah untuk mengetahui pengaruh kompensasi, lingkungan\r\nkerja dan promosi jabatan terhadap kepuasan kerja. Penelitian dilakukan di PT. Telkom\r\nIndonesia Wilayah Bali Selatan. Objek penelitian yaitu kompensasi, lingkungan kerja,\r\npromosi jabatan dan kepuasan kerja karyawan. Jumlah sampel yang digunakan sebanyak 74\r\norang, dengan metode sample random sampling. Pengumpulan data dilakukan melalui\r\nkoesioner dan observasi. Teknik analisis yang dipakai adalah regresi linear berganda.\r\nBerdasarkan hasil analisis disimpulkan bahwa kompensasi, lingkungan kerja dan promosi\r\njabatan berpengaruh signifikan terhadap kepuasan kerja.\r\nKata kunci: kompensasi, lingkungan kerja, promosi jabatan, kepuasan kerja', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/ej0008.pdf', ''),
('ej0009', 'lib001', 'PENGARUH LEVEREGE DAN PROFITABILITAS TERHADAP KEPUTUSAN HEDGING PERUSAHAAN MANUFAKTUR INDONESIA', 'PG0064', 'PT0049', 'ksi0038', 'SJ0058', 2016, '2302-8912', 'Manajemen', 'Penelitian ini menguji financial distress hypothesis yang menyatakan bahwa kondisi\r\nfinancial distress dapat di minimalisir apabila perusahaan melakukan aktivitas\r\nhedging dengan instrumen derivative. Penelitian ini bertujuan untuk menguji\r\nfinancial distress hypothesis di perusahaan manufaktur yang terdaftar dalam Bursa\r\nEfek Indonesia pada periode 2010-2013. Pengambilan sampel menggunakan teknik\r\npurposive sampling, dan sesuai kriteria yang telah ditetapkan didapat 125 sampel\r\nperusahaan dan 500 firm-year observation. Regresi logistik digunakan untuk\r\nmenguji financial distress hypothesis. Hasil pengujian menunjukkan bahwa variabel\r\ndebt to equity ratio sebagai proksi leverage memiliki pengaruh negatif namun tidak\r\nsignifikan secara statistik terhadap aktivitas hedging, sedangkan variabel return on\r\nasset sebagai proksi profitabilitas memiliki pengaruh yang positif dan signifikan\r\nterhadap aktivitas hedging.\r\nKata Kunci: financial distress, leverage, profitabilitas, hedging', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/ej0009.pdf', ''),
('ej0010', 'lib001', 'PENGARUH KUALITAS LAYANAN DAN CITRA PERUSAHAAN TERHADAP KEPUASAN NASABAH PADA BANK OCBC NISP DI DENPASAR', 'PG0065', 'PT0049', 'ksi0038', 'SJ0059', 2016, ' 2302-8912', 'Manajemen', 'Tujuan penelitian adalah untuk mengetahui pengaruh kualitas layanan dan citra perusahaan\r\npada Bank OCBC NISP di Denpasar. Penelitian ini dilakukan pada Bank OCBC NISP di\r\nDenpasar. Jumlah sampel ditetapkan sebanyak 105 responden, dengan metode nonprobability\r\nsampling yaitu purposive sampling dan pengumpulan data dilakukan melalui\r\npenyebaran kuisioner. Teknik analisis data yang digunakan adalah menggunakan teknik\r\nanalisis regresi berganda dan berdasarkan hasil analisis ditemukan bahwa citra perusahaan\r\nberpengaruh positif dan signifikan terhadap kepuasan nasabah pada Bank OCBC NISP di\r\nDenpasar. Kemudian kualitas layanan juga berpengaruh positif dan signifikan terhadap\r\nkepuasan nasabah pada Bank OCBC NISP di Denpasar.\r\nKata kunci: kualitas layanan, citra perusahaan, kepuasan nasabah', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/ej0010.pdf', ''),
('ej0011', 'lib001', 'STUDI KESIAPAN INFRASTRUKTUR KOMUNIKASI INFORMASI MENYONGSONG MANADO KOTA PARIWISATA DUNIA (MKPD) 2010', 'PG0066', 'PT0050', 'ksi0039', 'SJ0060', 2007, '1410-8291', 'Ilmu Komunikasi', 'Penelitian ini ingin melihat kesiapan infrastruktur komunikasi\r\ninformasi dalam menyongsong Manado Kota Pariwisata Dunia\r\n(MKPD) tahun 2010. Jenis penelitian adalah kualitatif dengan\r\nanalisis deskriptif, sedangkan metode penelitian bersifat\r\nsosiologis/empiris. Instrumen utama interview guide bersifat terbuka\r\ndan terstruktur. Ketersediaan alat komunikasi dan informasi belum\r\ncukup serta belum maksimal sebagai dukungan sarana dan prasarana\r\nmenyongsong MKPD tahun 2010. Yang menjadi kendala lainnya\r\nkemampuan Sumber Daya Manusia (SDM) -nya. Penggunaan internet\r\nhanya dipakai untuk mengakses informasi saja belum sampai pada\r\ntaraf penambahan pengetahuan/referensi tentang dunia wisata dalam\r\npersiapan menyongsong MKPD tahun 2010. Oleh karena itu perlu\r\nsosialisasi secara kontinyu kepada wisatawan mancanegara dan\r\ndomestik baik melalui dunia maya maupun secara langsung.\r\nKata kunci : Infrastruktur, MKPD 2010, Komunikasi Informasi.', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/ej0011.pdf', ''),
('ej0012', 'lib001', 'JURNAL JARINGAN KOMPUTER', 'PG0067', 'PT0051', 'ksi0002', 'SJ0002', 2010, '', 'Manajemen Informatika', 'Jaringan komputer bukanlah sesuatu yang baru saat ini. Hampir di setiap perusahaan\r\nterdapat jaringan komputer untuk memperlancar arus informasi di dalam perusahaan tersebut.\r\nInternet yang mulai populer saat ini adalah suatu jaringan komputer raksasa yang merupakan\r\njaringan komputer yang terhubung dan dapat saling berinteraksi. Hal ini dapat terjadi karena\r\nadanya perkembangan teknologi jaringan yang sangat pesat. Tetapi dalam beberapa hal\r\nterhubung dengan internet bisa menjadi suatu ancaman yang berbahaya, banyak serangan\r\nyang dapat terjadi baik dari dalam maupun luar seperti virus, trojan, maupun hacker. Pada\r\nakhirnya security komputer dan jaringan komputer akan memegang peranan yang penting\r\ndalam kasus ini.\r\nSuatu konfigurasi firewall yang baik dan optimal dapat mengurangi ancamanancaman\r\ntersebut. Konfigurasi firewall terdapat 3 jenis diantaranya adalah screened host\r\nfirewall system (single-homed bastion), screened host firewall system (Dual-homed bastion),\r\ndan screened subnet firewall. Dan juga mengkonfigurasikan firewall dengan membuka\r\nportport yang tepat untuk melakukan hubungan koneksi ke internet, karena dengan\r\nmengkonfigurasi port-port tersebut suatu firewall dapat menyaring paket-paket data yang\r\nmasuk yang sesuai dengan policy atau kebijakannya. Arsitektur firewall ini yang akan\r\ndigunakan untuk mengoptimalkan suatu firewall pada jaringan.', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/ej0012.pdf', ''),
('ej0013', 'lib001', 'Analisis Sistem Pengendalian Intern dan Pemanfaatan IT Governance Terhadap Keandalan Laporan Keuangan Pemerintah Daerah Kabupaten Minahasa Tenggara Menggunakan Frame Work Cobit (Control Objectives For', 'PG0068', 'PT0052', 'ksi0040', 'SJ0062', 2015, '1907-9737', 'Akuntansi', 'The purpose of this study was to assess the internal control system in a number of â€œSKPDâ€ in Southeast Minahasa Regency and check also the utilization of IT Governance at the â€œSKPDâ€. This study uses the COBIT framework to analyze the system of internal control and utilization of IT Governance in sectors in Southeast Minahasa Regency.\r\n\r\nThe method used in this research using descriptive method by distributing questionnaires purposive sampling to target treasurer, operator, or financial administration officials are determined randomly. Obtained data is then processed and dideskriptifkan by researchers thus a detailed explanation of the study.\r\n\r\nThe results showed that the Financial Statements To improve the reliability of the Local Government needed improvements in terms of control and monitoring activities. Meanwhile, IT Governance are not yet standardized, but have had the procedure. The most mature component is information architecture while most adults are communication objectives and management direction.\r\n\r\nKeywords : Internal Control System, SKPD, and IT Governance\r\n', 'Tersedia', '2016-02-04', '2016-02-04', 'upload_file/ej0013.docx', ''),
('ej0014', 'lib001', 'Prosedur Perhitungan dan Pelaporan Pajak Penghasilan Pasal 21 Atas Gaji Pegawai Pemerintah Kabupaten Minahasa Selatan', 'PG0069', 'PT0052', 'ksi0036', 'SJ0063', 2015, '1907-9737', 'Akuntansi', 'Income tax (VAT) of article 21 is a tax on income in the form of salaries, wages, fees, allowances, and other similar remuneration derived by any individual taxpayer in respect of employment or office, services, and activities. The purpose of this study is to provide an explanation of the implementation of the calculation and deduction, income tax reporting section 21 and the amount of income tax revenue has been recapitulated by the Government of South Minahasa District. This study used a descriptive analysis method by comparing theory and rules perpajakn there with the data obtained. From the research, it was found the procedure of calculation and reporting of income tax article 21 in the South Minahasa District Government has been good. It can be seen from the calculation until the reporting mechanism has been carried out based on the rules that apply. The use of services and applications for the calculation of Income Tax Article 21 of the PT. TASPEN in connection with the cooperation with the Government of South Minahasa.\r\n\r\nKeywords: Income tax (VAT) of article 21\r\n', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0014.docx', ''),
('ej0015', 'lib001', 'PELAKSANAAN PEMERIKSAAN LAPORAN KEUANGAN PEMERINTAH DAERAH OLEH ANGGOTA TIM YUNIOR PADA BADAN PEMERIKSA KEUANGAN REPUBLIK INDONESIA PERWAKILAN PROVINSI SULAWESI UTARA', 'PG0070', 'PT0052', 'ksi0041', 'SJ0064', 2015, '1907-9737', 'Akuntansi', 'This study used a qualitative ethnographic method aimed to analyze the condition of the local government''s financial statements examination by the examiner to the role of the Youth Team Member Audit Board and the things behind the condition. Data collected by means of interviews and observations at the time of examination of LKPD Talaud Islands and South Minahasa District for Fiscal Year 2013. The results showed that in the field of education and training of qualified inspectors have determined. In the examination of the planning process is not all examiners were involved in the preparation of the examination program while in the process of implementation of the inspection there are weaknesses such as inspection measures that can not be solved completely, different abilities to each examiner, and the preparation of paper checks that have not been fully resolved in the field . Furthermore, in the reporting process examiner had stints exceeding portion Youth Team Member.\r\n\r\nKeywords: Examination, LKPD, Youth Team Member, Audit Board.\r\n', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0015.docx', ''),
('ej0016', 'lib001', 'Masalah-Masalah Moral Masyarakat di Surat Kabar:  Studi Kasus terhadap Halaman â€œKasusâ€ di Surat Kabar Harian Kedaulatan Rakyat', 'PG0071', 'PT0053', 'ksi0042', 'SJ0065', 2005, '161-174', 'Ilmu Komunikasi', 'Abstract: Information delivered by the media makes the people to communicate each other focus on that information. In the long run, communication about the same object between the people will construct a certain community characterized by the ideology of the media. In this sense, communication media plays its role constructing a community. Besides, communication media can also present the social reality only. It does not build a community, but just portraits it. Newspaper can build a certain community with information published in it. But it can just portrait the social reality of its readers. Kedaulatan Rakyat, the oldest newspaper in Indonesia, of course plays the functions above. It builds a community of the readers or just portraits the social reality of society. This paper describes moral problems of the people portrayed by Kedaulatan Rakyat especially its â€œKasusâ€ page. Economic moral cases stays in the first rank among others. The age of 26 up to 45 yearsâ€™ invidious is critical ages for doing immoral acts.\r\n\r\n\r\n\r\nKey words: economic moral cases, portrait of reality, Catholic\r\n', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0016.docx', ''),
('ej0017', 'lib001', 'Evaluasi terhadap Pelaksanaan Komunikasi Pemasaran Sosial  Non-Goverment Organization (NGO) untuk Isu-Isu Anti Kekerasan terhadap Perempuan', 'PG0072', 'PT0054', 'ksi0016', 'SJ0066', 2004, '143-160', 'Ilmu Komunikasi', 'This paper explains how social marketing communication used by Cut Nyak Dien, Yogyakarta and Spekham, Surakarta--those are non goverment organization (NGO)-- to sosialize issues about anti-violences to women. The result of research show evaluation fase in the social marekting fases were not done. They were not evaluate the messages were received or not;and they were not identify the level of target audiensâ€™ behaviour changes. The media that they used were variatives. Having social marketing communication, they always do with advocacy activities.\r\n\r\n\r\nKey words: social marketing, social campaign, non goverment organization, marketing communication, anti-violence to women.', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0017.docx', ''),
('ej0018', 'lib001', 'Demokrasi dan Kinerja Pers Indonesia', 'PG0073', 'PT0055', 'ksi0043', 'SJ0067', 2005, '119-142', 'Ilmu Komunikasi', 'Mass media, especially, press have important rules in the democration process. There are three criteria to evaluate performance of the press. Press as a civic forum, itâ€™s related to Habermasâ€™s public sphere that there is space for citizen to discuss about public interest in thhe free condition. Press as a watch-dog, that itâ€™s means press has to protec minority rights from malfuntion of majority power. Press as a mobilization agent, itâ€™s medium to increase society involment in the politic process.\r\n\r\n\r\nKey words: mass media, press, civic forum, wath-dog, mobilization agent\r\n', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0018.docx', ''),
('ej0019', 'lib001', 'Organisasi Profesi Jurnalis dan Kode Etik Jurnalistik', 'PG0074', 'PT0056', 'ksi0043', 'SJ0068', 2004, '113-126', 'Ilmu Komunikasi', 'If managed professionally, the function of the press will be maximum. A professionalism press will always keep the quality of the news, and this is depend on the capability of the journalist. A good journalist upholds the quality of the news and used it as an indicator whether the press function works well or not. It is because a good journalist will be very obedience to the application of the ethics code of his profession. To keep the journalistic code of ethics works, it is necessary to have a journalist organization. This organization of journalist profession to increase the press professionalism to the commitment to control the journalistic code of ethics', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0019.docx', ''),
('ej0020', 'lib001', 'THE UNTRANSLATABILITY OF TEXTS : HIGHLITING SOME  BASIC CONTRASTS BETWEEN ENGLISH AND INDONESIAN', 'PG0075', 'PT0057', 'ksi0044', 'SJ0069', 2005, '1858-3296', 'Sastra Inggris', 'As an effort to render meaning of an SLT into a TLT, a translator may encounter various problems. The problems may not only be due to linguistic contrasts between the two languages, but to cultural and geographical contrasts where the two languages are used as well. This writing has tried to highlight some basic contrasts between English and Indonesian in linguistic, cultural and geographical aspects that cause the translation problems. The examples presented here show that there are concepts in English which are entirely untranslatable into Indonesian because the two languages are used in two different regions and cultures. A certain concept is present in English, but is absent in Indonesian and vice versa. A certain concept exists in both English and Indonesian but the speakers of both languages have different perspective on the thing symbolized by the concept. So, although it is linguistically translatable, but is culturally unacceptable. Therefore the translator may not only encounter problems that are due to linguistic contrasts but also those due to cultural and geographical contrasts.', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0020.pdf', ''),
('ej0021', 'lib001', 'METAFORA DAN METONIMI KONSEPTUAL  (DATA BAHASA MANDAILING)', 'PG0076', 'PT0057', 'ksi0006', 'SJ0070', 2005, '1858-3296', 'Sastra Inggris', 'It was Lakoffianâ€™s side stated metaphor as a mentally matter conceptualized structurally prior to linguistic expression. Among of the studies concerning with that conceptual metaphor are such as orientational metaphor, ontological metaphor, and structural metaphor. In application to the case of bahasa Mandailing, theoretical view of orientational metaphor perceived ASCEND-DISCEND (NAIK-TURUN) respectively as oneâ€™s luck and unluck, or something good and bad happened to anyone else is apparently contradictory. In bahasa Mandailing, anything indicated as ASCEND (NAIK) in metaphors are not merely all perceived as something good or lucky. With so many orientational metaphors, in bahasa Mandailing, ascending matters are not always perceived as positive-valued things. Conversely, society of the language will perceive DISCEND (TURUN) or something reachable as positive-valued things. As another characteristic to the language concerned is divisibility of itâ€™s metaphorical structure, i.e. that it is possible for the other linguistic unit, in the kind of words, to be inserted between the metaphorical components.', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0021.pdf', ''),
('ej0022', 'lib001', 'BAHASA DAN KOMUNIKASI:  SUATU TINJAUAN SOSIO-PSIKOLINGUISTIK', 'PG0077', 'PT0057', 'ksi0045', 'SJ0071', 2005, '1858-3296', 'Sastra Inggris', 'This paper deals with the description of language (especially spoken language) and communication based on socio-psycholinguistics points of view. Spoken language was based on rule-governed structuring of meaningless sounds (phonemes) into basic units of meaning (morphemes), which are further structured by morphological rules and by syntactic rules into sentences. The meanings of words, sentences and entire utterances are determined by semantic rules. Together, these rules represent grammar. It is because shared knowledge of morphological, syntactic and semantic rules permits the generation and comprehension of almost limitless meaningful utterances that language is such powerful communication medium. In general, the socio-psycholinguistics tends to be more concerned with how something is said than with what is said â€“ with speech style rather than speech content â€“ although this is changing with the advent of discourse analysis. Paralanguage refers to all non-linguistic accompaniments of speech, such as volume, stress, speed, tone of voice, pauses, sighs, etc.\r\n\r\nKey words: bahasa, komunikasi, gaya tutur, parabahasa, paralinguistik, sosio-psikolinguistik, kelompok dalam, kelompok luar, kelompok etnolinguistik.\r\n', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0022.pdf', ''),
('ej0023', 'lib001', 'PROSES PENERJEMAHAN DENGAN ANALISIS FUNGSIONAL', 'PG0078', 'PT0057', 'ksi0045', 'SJ0072', 2005, '1858-3296', 'Sastra Inggris', 'This writing is dealing with the tremendous things that can be made on the process of translation. It tells the readers that the duty of a translator or interpreter is not to seek out the equivalence of the source language in the target language only, but he or she has to seek out the needs and goals of doing the present tasks. Then she or he can work rapidly to reach the purpose of doing the translational process. Here on this writing the writer wants to tell the readers about the process of translation through the functional grammar which is spread out by the English philosopher, Halliday, one of the professors at the Australian Universities.\r\n \r\n', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0023.pdf', ''),
('ej0024', 'lib001', 'Pengaruh Budaya Organisasi Terhadap Motivasi Dan Kepuasan Kerja Serta Kinerja Karyawan Pada Sub Sektor Industri Pengolahan Kayu Skala Menengah Di Jawa Timur', 'PG0079', 'PT0058', 'ksi0046', 'SJ0073', 2005, '171-188', 'Manajemen', 'Tujuan dari penelitian ini untuk memenemukan bagaimana besarnya\r\npengaruh Budaya Organisasi terhadap Motivasi, Kepuasan Kerja dan Kinerja\r\nkaryawan khususnya karyawan dibagian produksi. Unit analisisnya adalah\r\nkaryawan produksi pada subsektor industri pengolahan kayu di Jawa Timur.\r\nSecara positif perilaku seseorang akan berpengaruh terhadap kinerjanya,\r\ndisamping itu peneliti menguji hipotesis bahwa motivasi berpengaruh kepada\r\nkepuasan kerja dan kepuasan kerja berpengaruh terhadap kinerja. Hasilnya\r\nbahwa secara langsung motivasi berpengaruh terhadap kepuasan kerja sebesar\r\n1.462 dan motivasi berpengaruh terhadap kinerja sebesar 0.387, kepuasan kerja\r\nberpengaruh terhadap kinerja sebesar 0,003 dan budaya organisasi berpengaruh\r\nterhadap kinerja sebesar 0.506, budaya organisasi berpengaruh terhadap motivasi\r\nsebesar 0.680 dan budaya organisasi berpengaruh terhadap kepuasan kerja\r\nsebesar 1.183. Hasil penelitian ini dapat digunakan oleh peneliti berikutnya,\r\nsebagai bahan penelitian pada bidang ilmu pengetahuan perilaku organisasi atau\r\nilmu pengetahuan yang sejenisnya.\r\nKata kunci: budaya organisasi, motivasi, kepuasan kerja, kinerja dan\r\nperilaku manusia.', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0024.pdf', ''),
('ej0025', 'lib001', 'ANALISIS PENGARUH PRIVASI, KEAMANAN DAN KEPERCAYAAN TERHADAP NIAT UNTUK BERTRANSAKSI SECARA ONLINE DI OLX.CO.ID', 'PG0080', 'PT0059', 'ksi0047', 'SJ0074', 2014, '', 'Manajemen', 'Penelitian ini dilatarbelakangi oleh perubahan pola perilaku dan kebutuhan\r\nkonsumenyang dikarenakan perkembangan teknologi dan arus informasi menjadikan lebih\r\nbertingkah laku praktis yang berarti konsumen membutuhkan kecepatan dan ketepatan dalam\r\npemenuhan kebutuhannya. Hal ini menyebabkan terus berubahnya model e-commerce yang\r\ndikembangkan dengan pengemasan teknologi dan informasi yang lebih modern. Masyarakat\r\nsecara umum menyebutkan bahwa e-commerce merupakan jawaban atas kecepatan dan\r\nketepatan pemenuhan kebutuhan dimana e-commerce menawarkan salah satu keunggulan\r\nkompetitifnya yaitu menghapus konsep ruang dan waktu.Tujuan dari penelitian ini adalah untuk\r\nmengetahui dan menganalisis pengaruh privasi, keamanan, dan kepercayaan terhadap niat\r\nbertransaksi secara online di OLX.co.id baik secara simulutan maupun parsial serta mengetahui\r\ndan menganalisis variabel independen manakah yang berpengaruh dominan terhadap niat\r\nbertransaksi secara online di OLX.co.id.\r\nJenis Penelitian yang digunakan dalam penelitian ini adalah explanatory research dengan\r\nmetode suvei dan jumlah sampel dalam penelitian ini sebanyak 110 responden. Tehnik\r\npengambilan sampel tersebut diperoleh dengan menggunakan metode Accidental Sampling.\r\nSumber data menggunakan data primer dan menggunakan data sekunder yaitu literatur dan dari\r\ninternet. Sedangkan teknik analisis data yang digunakan pada penelitian ini adalah analisis\r\nkuantitatif dengan menggunakan analisis melalui bantuan program SPSS, yaitu: Analisis Regresi\r\nLinear.\r\nDari hasil penelitian dengan langkah-langkah yang dijelaskan di atas diperoleh hasil\r\nbahwa berdasarkan hasil analisis regresi linier berganda dengan menggunakan uji F (simultan)\r\nmaka dapat disimpulkan bahwa variabel privasi, keamanan, dan kepercayaan memiliki pengaruh\r\nsecara simulutan atau serentak terhadap variabel niat bertransaksi, kemudian hasil analisis uji t\r\ndapat disimpulkanvariabel privasi, keamanan, dan kepercayaan berpengaruh signifikan secara\r\nparsial terhadap variabel niat bertransaksi, dan berdasarkan hasil koefisien regresi (Standardized\r\nCoeffucients Beta) masing-masing, maka dapat ditemukan bahwa variabel yang berpengaruh\r\ndominan terhadap niat bertransaksi secara online di OLX.co.id adalah variabel keamanan.\r\nKatakunci: E-commerce, Privasi, Keamanan, Kepercayaan dan Niat Bertransaksi', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0025.pdf', ''),
('ej0026', 'lib001', 'Optimalisasi Cybermetric Indikator Scholar (Sc) Universitas Kristen Maranatha dengan Mengimplementasikan Sistem Jurnal Online', 'PG0081', 'PT0060', 'ksi0004', 'SJ0075', 2011, '0216-4280', 'Teknik Informatika', 'World Class University (WCU) is the final aim for every educational institution in todayâ€™s global era. The determination of the WCUâ€™s classification of University has been done by some independent organizations with so many estimation criteria depends on the point of view in determining the rating.\r\nThis research organized Maranathaâ€™s scientific journals that handled by the prodi or the faculty into a system called online journal. This organization of the Maranathaâ€™s scientific journal is ignoring the truth of the journalâ€™s writing rules that has been determined.\r\nThe implementation of the online journal system in organizing the scientific files is proven effective to increase the scholar webometric indicator that as a whole will affect the final result of the rating.\r\nKeywords: webometric, journal, research', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0026.pdf', ''),
('ej0027', 'lib001', 'SISTEM INFORMASI TUGAS AKHIR BERBASIS WEB (STUDI KASUS D3 MANAJEMEN INFORMATIKA TE FT UNESA)', 'PG0082', 'PT0061', 'ksi0004', 'SJ0076', 2013, '', 'Manajemen Informatika', 'Tugas Akhir adalah sarana untuk mengetahui kemampuan seorang mahasiswa apakah sudah menguasai ilmu\r\nyang diberikan dan layak untuk mengabdi di masyarakat sesuai dengan kompetensi yang diajarkan oleh kampus. Tugas\r\nAkhir atau sering disingkat TA merupakan langkah awal untuk dapat belajar dalam menghadapi dunia kerja yang akan\r\ndihadapi, dengan adanya Tugas Akhir mahasiswa dapat mempersiapkan diri untuk menyelesaikan proyek-proyek di\r\nmasa kerja nanti.Didalam Sistem Informasi Tugas Akhir ini Mahasiswa dapat melihat Judul-Judul Tugas Akhir yang\r\ntelah disetujui, Jika judul yang dimiliki mahasiswa tidak sama dengan judul yang ada maka mahasiswa bisa\r\nmelanjutkan mengerjakan proposal TA. Kemudian Mahasiswa mengajukan proposal TA ke dosen Pembimbing agar\r\ndapat disetujui untuk sidang proposal.Selain itu dalam Tugas Akhir ini Mahasiswa juga dapat melakukan bimbingan\r\nTugas Akhir melalui website ini dan juga mendaftar sidang Tugas Akhir.\r\nDiharapkan dengan adanya website ini, dapat salah satu sarana atau fasilitas yang mendukung dalam proses\r\npembuatan Tugas Akhir. Dan juga dapat menjadi salah satu referensi Mahasiswa dalam bidang pemrograman web\r\nmenggunakan PHP dan MySQL serta desain web menggunakan Dreamweaver.\r\nKata Kunci: PHP, MySQL, Tugas Akhir, Web, Sistem Informasi', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0027.pdf', ''),
('ej0028', 'lib001', 'SISTEM INFORMASI BERBASIS WEB UNTUK MEMBANTU KEGIATAN TRACER STUDY PROGRAM DIPLOMA INSTITUT PERTANIAN BOGOR', 'PG0083', 'PT0062', 'ksi0004', 'SJ0076', 2012, '', 'Manajemen Informatika', 'IPB Diploma Program has alumni that are broadly spread\r\nthroughout Indonesia. Tracer study is always conducted progressively\r\neach year. Other methods conducted include questionaire via post, email,\r\nmailing list, graduation ceremony, alumni meeting, etc. By evaluating\r\ntracer study, some innovations are needed to increase its activities.\r\nRegarding the advancement of web based technology and internet media\r\nthat has gone significant in Indonesia, one innovation for tracer study is a\r\nwebsite facility which can be accessed by alumni, assumed that all alumni\r\nhave internet access. IPB Diploma Program Tracer Study Information\r\nSystem is built on the basis of web technology. This system is aimed to\r\nincrease data collectivity and gives out information, in form of report with\r\ndefault format prepared by IPB Diploma Program. This research yields an\r\nIPB Diploma Program Tracer Study Information System which already\r\nhelps alumni and the data collection of user satisfaction. IPB Diploma\r\nProgram Tracer Study Information System has a feature to show report\r\nwhich makes alumni information and user satisfaction data to be easily\r\nobtained. The information shown is in the form of graphic and tabular\r\ndata. On the other hand, this system is also equipped with alumni\r\nsearching facility to track whether an alumni has already participated in\r\ntracer study activity.\r\nKeyword : Information system, tracer study, website facility', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0028.pdf', ''),
('ej0029', 'lib001', 'DESAIN MEDIA PEMBELAJARAN BERBASIS ANDROID STUDI EMPIRIS MATA PELAJARAN JAVA', 'PG0084', 'PT0063', 'ksi0004', 'SJ0077', 2014, '', 'Manajemen Informatika', 'Tujuan penelitian pengembangan desain media pembelajaran berbasis android studi empiris mata\r\npelajaran ini adalah tetap dapt dijalankan bersamaan dengan media pembelajaran yang sebelumnya,\r\nsehingga penyampaian ilmu kepada para siswa lebih menarik, inovatif dan kreatif, hal ini dapat\r\nmengurangi tingkat kejenuhan atau kebosanan siswa dalam menerima matapelajaran. Model\r\npengembangan yang digunakan mengacu pada model pengembangan ADDIE yaitu analysis, design,\r\ndevelopment, implementation, dan evaluation. Hasil pengembangan berupa aplikasi android yang memuat\r\nmateri mata pelajaran java, soal quiz beserta hasil nilai yang didapatkan.\r\nKata Kunci: Media Pembelajaran, Android, Bahasa Pemrograman Java', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0029.pdf', ''),
('ej0030', 'lib001', 'MEMBANGUN SISTEM INFORMASI PENDATAAN TUGAS AKHIR PADA AMIK AKMI BATURAJA', 'PG0085', 'PT0064', 'ksi0004', 'SJ0078', 2014, '', 'Manajemen Informatika', 'Proses pendataan judul Tugas Akhir yang sebelumnya dilakukan secara manual memiliki\r\nbeberapa kelemahan, diantaranya setiap terjadi penambahan jumlah mahasiswa bimbingan,\r\nrekapitulasi tidak berubah secara otomatis. Selain itu laporan yang dikelompokkan\r\nberdasarkan kriteria tertentu dibuat dalam waktu yang cukup lama. Oleh karena itu\r\ndibutuhkan sebuah sistem informasi Pendataan Tugas Akhir yang dapat membantu mengatasi\r\npermasalahan yang ada. Sistem Informasi Pendataan Tugas Akhir ini dibuat dengan\r\nmenggunakan Delphi dan database Microsoft Access. Bekerja dengan satu komputer dan\r\ndioperasikan oleh seorang staf program studi. Setelah menggunakan sistem informasi ini\r\ndiharapkan pengolahan data Tugas Akhir dapat dilakukan dengan lebih cepat dan\r\nmenghasilkan laporan yang lebih akurat', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/ej0030.pdf', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kalender_unpi`
--

CREATE TABLE IF NOT EXISTS `kalender_unpi` (
  `kd_libur` int(10) NOT NULL,
  `tgl` date NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kalender_unpi`
--

INSERT INTO `kalender_unpi` (`kd_libur`, `tgl`, `keterangan`) VALUES
(1, '2016-01-24', 'Weekend'),
(2, '2016-01-31', 'Weekend'),
(3, '2016-01-17', 'weekend'),
(4, '2016-02-07', 'weekend'),
(5, '2016-02-08', 'Tahun Baru Imlek'),
(6, '2016-02-14', 'weekend'),
(7, '2016-02-21', 'weekend'),
(8, '2016-02-28', 'weekend'),
(9, '2016-03-06', 'weekend'),
(10, '2016-03-09', 'Hari Raya Nyepi Tahun Baru Saka 1938');

-- --------------------------------------------------------

--
-- Struktur dari tabel `klasifikasi_buku`
--

CREATE TABLE IF NOT EXISTS `klasifikasi_buku` (
  `kode` varchar(10) NOT NULL,
  `kd_klasifikasi` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `klasifikasi_buku`
--

INSERT INTO `klasifikasi_buku` (`kode`, `kd_klasifikasi`, `nama`, `keterangan`) VALUES
('ksi0001', '006.3', 'Intelegensi Buatan', ''),
('ksi0002', '003.3', 'Model dan simulasi komputer', ''),
('ksi0003', '511.8', 'Model-model atau simulasi matematis', ''),
('ksi0004', '005', 'Pemrograman  komputer, program-program, data', ''),
('ksi0005', '006.7', 'Multimedia systems', ''),
('ksi0006', '425', 'Tata Bahasa  Inggris', ''),
('ksi0007', '823', 'Fiksi inggris', ''),
('ksi0008', '425', 'Tata Bahasa Inggris', ''),
('ksi0009', '301', 'Sosiologi dan antropologi', ''),
('ksi0010', '307', 'Masyarakat, Persekutuan hidup', ''),
('ksi0011', '338.5', 'Ekonomi produksi umum', ''),
('ksi0012', '657.3', 'Pelaporan keuangan (Pernyataan-pertanyaan keuangan', ''),
('ksi0013', '657.4', 'Bidang-bidang khusus akuntansi ', ''),
('ksi0014', '657.6', 'Jenis-jenis akuntansi : akuntansi pemerintah, akun', ''),
('ksi0015', '657', 'Akuntansi', ''),
('ksi0016', '302.2', 'Komunikasi', ''),
('ksi0017', '658', 'Manajemen Umum', ''),
('ksi0018', '070.4', 'Kegiatan-kegiatan jurnalistik', ''),
('ksi0019', '302', 'Komunikasi', ''),
('ksi0020', '001.4', 'Penelitian : metode-metode penelitian', ''),
('ksi0021', '650.1', 'Sukses pribadi dalam bisnis', ''),
('ksi0022', '070.5', 'Penerbit dan penerbitan', ''),
('ksi0023', '330.1', 'Sistem-sistem dan teori ekonomi', ''),
('ksi0024', '422', 'Etimologi Bahasa Inggris', ''),
('ksi0025', '303', 'Proses-proses Sosial', ''),
('ksi0026', '405', 'Tata Bahasa', ''),
('ksi0027', '928', 'Biografi sastrawan, sejarawan', ''),
('ksi0028', '400', 'Bahasa', ''),
('ksi0029', '428', 'Pemakaian bahasa Inggris', ''),
('ksi0030', '004', 'Pengolahan data ilmu komputer', ''),
('ksi0031', '658.83', 'Penelitian dan analisa pemasaran', ''),
('ksi0032', '658.8', 'Manajemen pendistribusian (pemasaran)', ''),
('ksi0033', '070.1', 'Media  berita : surat kabar, majalah, radio, telev', ''),
('ksi0034', '070.1', 'Media  berita : surat kabar, majalah, radio, telev', ''),
('ksi0035', '070.1', 'Media  berita : surat kabar, majalah, radio, telev', ''),
('ksi0036', '336.2', 'Pajak dan perpajakan', ''),
('ksi0037', '657.4', 'b', ''),
('ksi0038', '650', 'Manajemen', ''),
('ksi0039', '384', 'Komunikasi Telekomunikasi', ''),
('ksi0040', '657.3', 'Pelaporan keuangan (Pernyataan-pertanyaan keuangan', ''),
('ksi0041', '657.3', 'Pelaporan keuangan (Pernyataan-pertanyaan keuangan', ''),
('ksi0042', '070.1', 'Media  berita : surat kabar, majalah, radio, telev', ''),
('ksi0043', '070', 'PERS, JURNALISME, PENERBITAN, PERSURATKABARAN', ''),
('ksi0044', '820', 'KESUSASTRAAN BAHASA INGGRIS DAN ANGLO-SAXON', ''),
('ksi0045', '372.6', 'Bahasa dan kesusastraan', ''),
('ksi0046', '400.6', 'Organisasi dan manajemen', ''),
('ksi0047', '659.1', 'Periklanan', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kp`
--

CREATE TABLE IF NOT EXISTS `kp` (
  `kd_kp` varchar(20) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kd_penulis` varchar(20) NOT NULL,
  `kd_penerbit` varchar(20) NOT NULL,
  `kd_klasifikasi` varchar(20) NOT NULL,
  `kd_subjek` varchar(20) NOT NULL,
  `thn_terbit` int(4) NOT NULL,
  `issn_isbn` varchar(20) NOT NULL,
  `jurusan` varchar(25) NOT NULL,
  `abstrak` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `file` varchar(255) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kp`
--

INSERT INTO `kp` (`kd_kp`, `kd_petugas`, `judul`, `kd_penulis`, `kd_penerbit`, `kd_klasifikasi`, `kd_subjek`, `thn_terbit`, `issn_isbn`, `jurusan`, `abstrak`, `status`, `date_input`, `date_update`, `file`, `ket`) VALUES
('kp0001', 'lib001', 'Sistem Informasi Penyewaan Buku Taman Bacaan Blues Cianjur', 'PG0001', 'PT0001', 'ksi0004', 'SJ0061', 2015, '', 'Teknik Informatika', 'Sistem informasi penyewaan buku merupakan kebutuhan yang sangat diperlukan untuk kemudahan dalam proses input data, pengolahan data dan proses output karena pada Taman Bacaan Blues saat ini masih terdapat kekurangan pada manajemen data member, data buku, transaksi  penyewaan, dan transaksi pengembaliannya. Hingga tidak hanya beberapa kali terdapat buku yang hilang karena data peminjaman lama bertumpuk dengan data peminjaman yang baru.', 'Tersedia', '2016-02-04', '2016-02-04', 'upload_file/sp0001.doc', ''),
('kp0002', 'lib001', 'SISTEM INFORMASI PENJUALAN BERAS PM JAYA CIPANAS', 'PG0086', 'PT0001', 'ksi0004', 'SJ0078', 2015, '', 'Teknik Informatika', 'PM JAYA merupakan distributor dan gudang beras dengan sistem penjualan secara grosir dan eceran. Untuk pemesanan pihak perusahaan menyediakan jasa pengiriman kepada pemesan dengan jangka waktu sehari sebelumnya.  \r\nSelama melakukan Kerja Praktek, banyak permasalahan yang ditemukan, misalnya untuk peringatan kadaluarsa barang yang tersedia, pencatatan data transaksi penjualan belum maksimal dikarenakan pada bagian administrasi sering mengalami kesulitan dalam proses pengolahan data transaksi penjualan karena data yang disimpan masih menggunakan buku besar. Dalam pengumpulan dan pengolahan data yang dilakukan masih dalam bentuk manual yaitu dengan hanya menggunakan nota biasa sebagai kwitansi pembayaran dan laporan penjualan maupun pembelian, sehingga sering terjadi kesalahan dan kekeliruan dalam pencatatan. Oleh karena itu penulis mencoba untuk membuat suatu program aplikasi inventory stok barang PM JAYA yang cepat, akurat, tepat waktu, relevan serta efektif.\r\n', 'Tersedia', '2016-02-04', '0000-00-00', 'upload_file/kp0002.rar', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `makalah`
--

CREATE TABLE IF NOT EXISTS `makalah` (
  `kd_makalah` varchar(20) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kd_penulis` varchar(20) NOT NULL,
  `kd_penerbit` varchar(20) NOT NULL,
  `kd_klasifikasi` varchar(20) NOT NULL,
  `kd_subjek` varchar(20) NOT NULL,
  `thn_terbit` int(4) NOT NULL,
  `issn_isbn` varchar(20) NOT NULL,
  `jurusan` varchar(25) NOT NULL,
  `abstrak` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `file` varchar(255) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `makalah`
--

INSERT INTO `makalah` (`kd_makalah`, `kd_petugas`, `judul`, `kd_penulis`, `kd_penerbit`, `kd_klasifikasi`, `kd_subjek`, `thn_terbit`, `issn_isbn`, `jurusan`, `abstrak`, `status`, `date_input`, `date_update`, `file`, `ket`) VALUES
('sp0001', 'lib001', 'Sistem Pakar', 'PG0001', 'PT0001', 'ksi0001', 'SJ0001', 2014, '', 'Teknik Informatika', 'Pengertian Sistem Pakar (expert system) adalah sistem/program yang bertingkah laku seperti ahlinya atau pakarnya. Sistem pakar merupakan sistem yang berbasis pengetahuan digunakan untuk membantu menyelesaikan masalah-masalah yang ada dalam dunia nyata.', 'Tersedia', '2016-01-21', '0000-00-00', 'upload_file/sp0001.pdf', ''),
('sp0002', 'lib001', 'Jaringan Komputer', 'PG0002', 'PT0001', 'ksi0002', 'SJ0002', 2014, '', 'Teknik Informatika', 'Tidak ada abstrak', 'Tersedia', '2016-01-21', '2016-01-29', 'upload_file/sp0002.pdf', ''),
('sp0003', 'lib001', 'Manajemen Proyek Membangun Rumah', 'PG0003', 'PT0001', 'ksi0003', 'SJ0003', 2014, '', 'Teknik Informatika', '-', 'Tersedia', '2016-01-21', '0000-00-00', 'upload_file/sp0003.pdf', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE IF NOT EXISTS `peminjaman` (
  `kd_pinjam` varchar(20) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  `kd_member` varchar(20) NOT NULL,
  `jml_buku` int(2) NOT NULL,
  `tgl_pinjam` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`kd_pinjam`, `kd_petugas`, `kd_member`, `jml_buku`, `tgl_pinjam`) VALUES
('201601230001', 'superadmin3006', 'n001', 3, '2016-01-23'),
('201601270001', 'superadmin3006', 's001', 1, '2016-01-27'),
('201601280001', 'superadmin3006', 's003', 3, '2016-01-28'),
('201602220001', 'lib001', 'f001', 3, '2016-02-22'),
('201602220002', 'lib001', 's002', 3, '2016-02-22'),
('201602220003', 'lib001', 'a001', 1, '2016-02-22'),
('201602250001', 'lib001', 'i001', 3, '2016-02-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbit`
--

CREATE TABLE IF NOT EXISTS `penerbit` (
  `kd_penerbit` varchar(20) NOT NULL,
  `nama_penerbit` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penerbit`
--

INSERT INTO `penerbit` (`kd_penerbit`, `nama_penerbit`, `kota`) VALUES
('PT0001', 'UNPI', 'Cianjur'),
('PT0002', 'STMIK Budi Darma', 'Medan'),
('PT0003', 'FMIPA Universitas Mulawarman', 'Samarinda'),
('PT0004', 'STMIK Budidarma', 'Medan'),
('PT0005', 'Universitas Ahmad Dahlan', 'Yogyakarta'),
('PT0006', 'Penerbit Andi', 'Yogyakarta'),
('PT0007', 'Gava Media', 'Yogyakarta'),
('PT0008', 'Informatika', 'Bandung'),
('PT0009', 'Wacana Intelektual', 'Jakarta'),
('PT0010', 'Sphere', 'US'),
('PT0011', 'Tangga Pustaka', 'Jakarta'),
('PT0012', 'Rosada Karya', 'Bandung'),
('PT0013', 'Refika Aditama', 'Bandung'),
('PT0014', 'ALFABETA', 'Bandung'),
('PT0015', 'Salemba Empat', 'Jakarta'),
('PT0016', 'Lembaga Penerbit Fakultas Ekonomi Universitas Indo', 'Jakarta'),
('PT0017', 'Lembaga Penerbit Fakultas Ekonomi Universitas Indo', 'Jakarta'),
('PT0018', 'BPFE', 'Yogyakarta'),
('PT0019', 'PT RajaGrafindo Persada', 'Jakarta'),
('PT0020', 'PT Elex Media Komputido', 'Jakarta'),
('PT0021', 'Macmillan Publishing Company', 'New York'),
('PT0022', 'PT Remaja Rosadakarya', 'Bandung'),
('PT0023', 'PT Alumni', 'Bandung'),
('PT0024', 'Erlangga', 'Jakarta'),
('PT0025', 'PT. Rinneka Cipta', 'Jakarta'),
('PT0026', 'PT Gramedia Pustaka Utama', 'Jakarta'),
('PT0027', 'PT Bumi Aksara', 'Jakarta'),
('PT0028', 'PT Refika Aditama', 'Bandung'),
('PT0029', 'Prentice Hall Regents', 'New Jersey'),
('PT0030', 'Pearson Education', 'New York'),
('PT0031', 'Capstone', 'West Sussex'),
('PT0032', 'Pena Multimedia', 'Jakarta'),
('PT0033', 'PT Angkasa Bandung', 'Bandung'),
('PT0034', 'PT Nuansa Aulia', 'Bandung'),
('PT0035', 'Orion Publishing', 'London'),
('PT0036', 'Cambridge University Press', 'Cambridge'),
('PT0037', 'Graha Ilmu', 'Yogyakarta'),
('PT0038', 'Lembaga Penelitian Universitas Airlangga', 'Jakarta'),
('PT0039', 'Universitan Hasanudin', 'Makasar'),
('PT0040', 'Universitas Diponogoro', 'Semarang'),
('PT0041', 'UNIVERSITAS KATOLIK WlDYA MANDALA', 'Surabaya'),
('PT0042', 'Universitan Hasanudin', 'Semarang'),
('PT0043', 'Universitas Padjajaran', 'Bandung'),
('PT0044', 'Universitas Islam Negeri Syarif Hidayatullah', 'Jakarta'),
('PT0045', 'STMIK PERBANAS', 'Jakarta'),
('PT0046', 'Unika Widya Mandala', 'Surabaya'),
('PT0047', 'Universitas Lampung', 'Bandar Lampunt'),
('PT0048', 'Universitas L', 'Bandar Lampunt'),
('PT0049', 'Universitas Udayana', 'Bali'),
('PT0050', 'DEPKOMINFO', 'Bandung'),
('PT0051', 'STMIK Banjarbaru', 'Banjarmasin'),
('PT0052', 'Universitas Sam Ratulangi Manado', 'Manado'),
('PT0053', 'Universitas Atma Jaya Yogyakarta', 'Yogyakarta'),
('PT0054', 'Universitas Muhammadiyah Yogyakarta', 'Yogyakarta'),
('PT0055', 'Dewan Pers Yogyakarta', 'Yogyakarta'),
('PT0056', 'STMPD â€œ APMDâ€ Yogyakarta', 'Yogyakarta'),
('PT0057', 'Universitas Sumatra Utara', 'Medan'),
('PT0058', 'Universitas Katholik Widya Mandala', 'Surabaya'),
('PT0059', 'FEB Universitas Brawijaya', 'Malang'),
('PT0060', 'Universitas Kristen Maranatha', 'Bandung'),
('PT0061', 'Universitas Negeri Surabaya', 'Surabaya'),
('PT0062', 'IPB', 'Bogor'),
('PT0063', 'STMIK ASIA Malang', 'Malang'),
('PT0064', 'AMIK AKMI Baturaja', 'Baturaja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengarang`
--

CREATE TABLE IF NOT EXISTS `pengarang` (
  `kd_pengarang` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `penyunting` varchar(50) NOT NULL,
  `penterjemah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengarang`
--

INSERT INTO `pengarang` (`kd_pengarang`, `nama`, `jenis`, `penyunting`, `penterjemah`) VALUES
('PG0001', 'Sarah Siti S', 'Perorangan', '', ''),
('PG0002', 'Roby, Rizky, Sarah, Asep, Munif, Andri, Andian, Anis, Nuni, Jijim', 'Kelompok', '', ''),
('PG0003', 'Jijim, Sarah, Nuni', 'Kelompok', '', ''),
('PG0004', 'Goyanti L.Tobing', 'Perorangan', '', ''),
('PG0005', 'Addy Suyatno', 'Perorangan', '', ''),
('PG0006', 'Sepdiarina Simarmata', 'Perorangan', '', ''),
('PG0007', 'Yana Hendriana', 'Perorangan', '', ''),
('PG0008', 'Martin Fowler', 'Perorangan', '', ''),
('PG0009', 'Rachmad Saleh', 'Perorangan', '', ''),
('PG0010', 'Iwan Binanto', 'Perorangan', '', ''),
('PG0011', 'Bambang Hariyanto', 'Perorangan', '', ''),
('PG0012', 'Windi Novia', 'Perorangan', '', ''),
('PG0013', 'Nicholas Sparks', 'Perorangan', '', ''),
('PG0014', 'Agustin Leoni ', 'Perorangan', '', ''),
('PG0015', 'Jalaluddin Rakhmat', 'Perorangan', '', ''),
('PG0016', 'Munandar Soelaeman', 'Perorangan', '', ''),
('PG0017', 'Dr. Wilson Bangun', 'Perorangan', '', ''),
('PG0018', 'Subandi', 'Perorangan', '', ''),
('PG0019', 'Erly Suandy', 'Perorangan', '', ''),
('PG0020', 'Sukrisno Agoes', 'Perorangan', '', ''),
('PG0021', 'Sukrisno Agoes, Estralita Trisnawati', 'Kelompok', '', ''),
('PG0022', 'Revrisond Baswir', 'Perorangan', '', ''),
('PG0023', 'Dr. Eddy Mulyadi Soepardi', 'Perorangan', '', ''),
('PG0024', 'Joel G. Siegel, Jae K. Shim', 'Kelompok', '', ''),
('PG0025', 'Wanda A. Wallace, James J. Wallace', 'Kelompok', '', ''),
('PG0026', 'Nurudin', 'Perorangan', '', ''),
('PG0027', 'Rosady Ruslan', 'Perorangan', '', ''),
('PG0028', 'Charles R. Wright', 'Perorangan', 'Drs. Jalaluddin Rakhmat, M. Sc.', 'Lilawati Trimo, Drs. Jalaluddin Rakhmat, M. Sc.'),
('PG0029', 'Drs. Onong U. Effendy, M.A', 'Perorangan', '', ''),
('PG0030', 'William A. Haviland', 'Perorangan', '', 'R.G Soekadiho'),
('PG0031', 'Prof. Dr. Deddy Mulyana, M.A., Ph.D.', 'Perorangan', '', ''),
('PG0032', 'Prof. Dr. Suharsimi Arikunto', 'Perorangan', '', ''),
('PG0033', 'M. Fuad, Christine H., Nurlela, Sugiarto, Paulus, Y.E.F', 'Kelompok', '', ''),
('PG0034', 'T. Hani Handoko', 'Perorangan', '', ''),
('PG0035', 'Suliyanto, SE., M.Si.', 'Perorangan', '', ''),
('PG0036', 'Dr. Harmono, S.E., M.Si.', 'Perorangan', '', ''),
('PG0037', 'Drs. Totok Djuroto, M.Si', 'Perorangan', '', ''),
('PG0038', 'Nopirin, Ph. D', 'Perorangan', '', ''),
('PG0039', 'Betty Schrampfer Azar', 'Perorangan', '', ''),
('PG0040', 'Betty Schrampfer Azar, Stacy A. Hagen', 'Kelompok', '', ''),
('PG0041', 'Heather Summers, Anne Watson', 'Kelompok', '', ''),
('PG0042', 'Ahmad Bahar', 'Perorangan', '', ''),
('PG0043', 'Prof. Dr. Henry Guntur Tarigan', 'Perorangan', '', ''),
('PG0044', 'Laelasari, S.S., Nurlailah, S.s', 'Kelompok', '', ''),
('PG0045', 'Ralph Waldo Emerson', 'Perorangan', '', ''),
('PG0046', 'Raymond Murphy', 'Perorangan', '', ''),
('PG0047', 'Sudarmawan, ST, MT, Dony Ariyus', 'Kelompok', '', ''),
('PG0048', 'Budi Halus Santoso', 'Perorangan', '', ''),
('PG0049', 'Dwi Sanjaya', 'Perorangan', '', ''),
('PG0050', 'Tina Nuralitasari', 'Perorangan', '', ''),
('PG0051', 'Fadel Ridlafalah A', 'Perorangan', '', ''),
('PG0052', 'Deny Arnos Kwary, S.S., Dra. Ida Nurul Chasanah, S.S.,M.Hum.', 'Kelompok', '', ''),
('PG0053', 'Nurul Rizky Fachira', 'Perorangan', '', ''),
('PG0054', 'ANNISA META CEMPAKA WANGI', 'Perorangan', '', ''),
('PG0055', 'Iksan Hasari Nasution', 'Perorangan', '', ''),
('PG0056', 'VIVI CAROLINE', 'Perorangan', '', ''),
('PG0057', 'RACHEL PRISCELLA SIRIWA', 'Perorangan', '', ''),
('PG0058', 'YOGIE TRIHANDOKO SUGIYO', 'Perorangan', '', ''),
('PG0059', 'Irna Febrianti', 'Perorangan', '', ''),
('PG0060', 'Taufik Surya Hidayat ', 'Perorangan', '', ''),
('PG0061', 'YUSTINA YONATAN', 'Perorangan', '', ''),
('PG0062', 'A. Zubaidi Indra, Agus Zahron, Ana Rosianawati', 'Kelompok', '', ''),
('PG0063', 'Made Bayu Indra Nugraha, Ida Bagus Ketut Surya', 'Kelompok', '', ''),
('PG0064', 'RM Satwika Putra Jiwandhana, Nyoman Triaryati', 'Kelompok', '', ''),
('PG0065', 'Luh Ayu Mulyaningsih, I Gst Agung Ketut Gede Suasana', 'Kelompok', '', ''),
('PG0066', 'Ramon', 'Perorangan', '', ''),
('PG0067', 'Sani Abdillah', 'Perorangan', '', ''),
('PG0068', 'Halens Ryanlie Ole, Grace Nangoi, Heince R. N. Wokas', 'Kelompok', '', ''),
('PG0069', 'Andre Mandak ,Jenny Morasa', 'Kelompok', '', ''),
('PG0070', 'Rizal Y., Budiman Jullie J., Sondakh Winston Pontoh', 'Kelompok', '', ''),
('PG0071', 'Y. Agus Tridiatno', 'Perorangan', '', ''),
('PG0072', 'Tri Hastuti Nur R', 'Perorangan', '', ''),
('PG0073', 'I Gusti Ngurah Putra', 'Perorangan', '', ''),
('PG0074', 'Fadjarini Sulistyowati', 'Perorangan', '', ''),
('PG0075', 'Syahron Lubis', 'Perorangan', '', ''),
('PG0076', 'Namsyah Hot Hasibuan', 'Perorangan', '', ''),
('PG0077', 'Eddy Setia', 'Perorangan', '', ''),
('PG0078', 'Matius C.A. Sembiring', 'Perorangan', '', ''),
('PG0079', 'H.Teman Koesmono', 'Perorangan', '', ''),
('PG0080', 'Muhammad Syaifudin', 'Perorangan', '', ''),
('PG0081', 'Bernard Renaldy Suteja, Wilfridus Bambang Triadi Handaya', 'Kelompok', '', ''),
('PG0082', 'Puspita Aritias Anggaeni', 'Perorangan', '', ''),
('PG0083', 'Sofiyanti Indriasari', 'Perorangan', '', ''),
('PG0084', 'Setyorini', 'Perorangan', '', ''),
('PG0085', 'Estiningrum', 'Perorangan', '', ''),
('PG0086', 'Roby Handoko', 'Perorangan', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE IF NOT EXISTS `petugas` (
  `kd_petugas` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nik` varchar(15) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `ttl` date NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `last_log` datetime NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`kd_petugas`, `nama`, `nik`, `jk`, `ttl`, `alamat`, `tlp`, `jabatan`, `email`, `password`, `date_input`, `date_update`, `image`, `status`, `last_log`, `level`) VALUES
('lib001', 'Eli Rosita', '13130987635', 'Wanita', '1980-08-20', 'Jl. Asnawi Rt 01/20 Kampung Lio Kelurahan Muka Cianjur', '085722299593', 'Petugas', 'elirosita1980@gmail.com', 'elirosita', '2016-01-21', '2016-01-29', 'assets/pl/lib001.jpg', 'Aktif', '2016-02-25 08:37:02', 'petugas'),
('superadmin3006', 'Sarah', '', 'Wanita', '1993-06-30', 'Jl. Selamet No. 29', '089694997568', 'Administrator', 'yamato.kara@yahoo.com', 'sarah', '2015-12-19', '0000-00-00', 'assets/img/me2.jpg', 'Aktif', '2016-02-22 08:48:16', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `kd_req` varchar(20) NOT NULL,
  `kd_pengaju` varchar(20) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `th_terbit` int(4) NOT NULL,
  `edisi` varchar(50) NOT NULL,
  `tgl_req` date NOT NULL,
  `realisasi` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `request`
--

INSERT INTO `request` (`kd_req`, `kd_pengaju`, `judul`, `pengarang`, `penerbit`, `th_terbit`, `edisi`, `tgl_req`, `realisasi`) VALUES
('Req0001', 'superadmin3006', 'Langsung Bisa Visual Basic.NET 2008', 'Rahmat Priyanto', 'Penerbit Andi', 2009, '1', '2016-01-21', 1),
('Req0002', 'superadmin3006', 'Sehari Menjadi Programmer Antivirus Menggunakan VB', 'A.M Hirin', 'Penerbit Andi', 2008, '1', '2016-01-21', 0),
('Req0003', '11720027', 'Membongkar Rahasia Blog', 'Jubilee Enterprise', 'Elex Media Komputindo', 2011, '1', '2016-01-21', 0),
('Req0004', '12620015', '101+ Solusi Ahli Komputer', 'Ridwan Sanjaya dan Fredy Setyawan', 'Penerbit Andi', 2010, '1', '2016-01-21', 0),
('Req0005', '12620015', 'Avalon High', 'Meg Cabot', 'Gramedia Pustaka Utama', 2006, '1', '2016-01-21', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sirkulasi`
--

CREATE TABLE IF NOT EXISTS `sirkulasi` (
  `kd_sirkulasi` varchar(10) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `harga_sewa` int(6) NOT NULL,
  `denda` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sirkulasi`
--

INSERT INTO `sirkulasi` (`kd_sirkulasi`, `jenis`, `harga_sewa`, `denda`) VALUES
('SI01', 'Circulation', 0, 1000),
('SI02', 'Non-circulation', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi`
--

CREATE TABLE IF NOT EXISTS `skripsi` (
  `kd_skripsi` varchar(20) NOT NULL,
  `kd_petugas` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kd_penulis` varchar(20) NOT NULL,
  `kd_penerbit` varchar(20) NOT NULL,
  `kd_klasifikasi` varchar(20) NOT NULL,
  `kd_subjek` varchar(20) NOT NULL,
  `thn_terbit` int(4) NOT NULL,
  `issn_isbn` varchar(20) NOT NULL,
  `jurusan` varchar(25) NOT NULL,
  `abstrak` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_input` date NOT NULL,
  `date_update` date NOT NULL,
  `file` varchar(255) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skripsi`
--

INSERT INTO `skripsi` (`kd_skripsi`, `kd_petugas`, `judul`, `kd_penulis`, `kd_penerbit`, `kd_klasifikasi`, `kd_subjek`, `thn_terbit`, `issn_isbn`, `jurusan`, `abstrak`, `status`, `date_input`, `date_update`, `file`, `ket`) VALUES
('skp0001', 'lib001', 'An Analysis Of Primary Auxiliary Verbs In The Novel Divergent By Veronica Roth â€œA Study Of Syntax And Semantics', 'PG0050', 'PT0001', 'ksi0008', 'SJ0044', 2015, '', 'Sastra Inggris', 'According to M. A. K. Halliday in the title book On Language and Linguistics  (2003: 117), â€œLanguage is as much a product of evolution as we are ourseleves; we did not manufacture itâ€. Syntax is a branch of linguistic which study of the structure of sentence. It is can classification of word  according to their functions of sentence.  Semantic is a branch of linguistic which study of meaning of language. Semantics according to Hornby in Oxford Advanced Learnerâ€™s Dictionary (2000: 1209) â€œSemantics is the study of the meaning of words and phrasesâ€. Linguistic is a completed subject to know the meaning of word in the content and how to arrange the word. On the other hand the writer tries to describe and analyze about linguistic, especially syntax and semantics.', 'Tersedia', '2016-01-27', '2016-02-25', 'assets/bp/skp0001.rar', ''),
('skp0002', 'lib001', 'Aplikasi Sistem Pakar Diagnosa Penyakit Pada Mata Berbasis Web', 'PG0051', 'PT0001', 'ksi0001', 'SJ0001', 2015, '', 'Teknik Informatika', 'Kebutaan dan gangguan penglihatan tidak hanya mengganggu produktivitas dan mobilitas, tetapi juga menimbulkan dampak sosial dan ekonomi bagi lingkungan, keluarga, masyarakat dan negara artinya rendahnya produktivitas orang dengan kecacatannya (tuna netra) jelas berdampak negatif kepada pendapatan (income) yang optimal dari suatu keluarga dan kemudian suatu daerah tempat tinggalnya. Mobilitas mereka yang rendah di lain pihak menjadi tanggungan orang yang melihat untuk membantu bergerak dari suatu tempat ke tempat yang lain atau dari satu kegiatan ke kegiatan yang lain sehingga produktifitas orang yang melihat pun menjadi terganggu.', 'Tersedia', '2016-01-27', '2016-01-29', 'upload_file/skp0002.doc', ''),
('skp0003', 'lib001', 'PENGARUH BRAND IMAGE TERHADAP KEPUTUSAN PEMBELIAN MOBIL MEREK PAJERO SPORT PADA PT. BOSOWA BERLIAN MOTOR', 'PG0053', 'PT0039', 'ksi0031', 'SJ0046', 2012, '', 'Manajemen', 'Tujuan penelitian ini adalah : (i) untuk menganalisis pengaruh brand image\r\nmeliputi kualitas merek, loyalitas merek dan asosiasi merek terhadap keputusan\r\npembelian mobil Pajero Sport pada PT. Bosowa Berlian Motor, dan (ii) untuk\r\nmenganalisis diantara brand image tersebut berpengaruh dominan terhadap keputusan\r\npembelian mobil Pajero Sport pada PT. Bosowa Berlian Motor.\r\nPenelitian ini memakai metode deskriptif kuantitatif. Populasi dan sampel\r\npenelitian sebanyak 93 responden (full sampling). Teknik analisa data dalam\r\npenelitian ini adalah analisis Regresi Linier Berganda.\r\nHasil penelitian menemukan bahwa secara simultan setelah diuji dengan uji-\r\nFisher (F) ditemukan bahwa brand image berupa kualitas merek, loyalitas merek dan\r\nasosiasi merek signifikan berpengaruh terhadap keputusan pembelian mobil Pajero\r\nSport pada PT. Bosowa Berlian Motor Makassar. Brand image berupa asosiasi merek\r\nmerupakan faktor dominan dan signifikan yang berpengaruh terhadap keputusan\r\npembelian mobil Pajero Sport pada PT. Bosowa Berlian Motor Makassar. Asosiasi\r\nmerek yang diterapkan ditentukan oleh kemampuan perusahaan dalam menciptakan\r\ninformasi padat bagi pelanggan dan bisa mempengaruhi pengingatan kembali atas\r\ninformasi tersebut, terutama saat mengambil keputusan pembelian produk mobil\r\nPajero Sport. Asosiasi merek ditentukan oleh kredibilitas, strategi positioning yang\r\nditerapkan dan persepsi konsumen.\r\nSaran yang diberikan yaitu menjadi bahan evaluasi bagi PT. Bosowa Berlian\r\nMotor Makassar dalam meningkatkan keputusan pembelian dengan memperbaiki\r\nbrand image dari produk yang ditawarkan yang mampu memberikan ketertarikan\r\nkepada konsumen untuk membeli produk mobil merek Pajero Sport.', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/skp0001.pdf', ''),
('skp0004', 'lib001', 'Analisis Manajemen Laba dan Kinerja Keuangan Perusahaan Pengakuisisi Sebelum dan Sesudah Merger dan Akuisisi  yang Terdaftar di Bursa Efek Indonesia', 'PG0054', 'PT0040', 'ksi0017', 'SJ0047', 2010, '', 'Manajemen', 'Tujuan dari penelitian ini adalah untuk mendapatkan bukti empiris apakah\r\nperusahaan pengakuisisi melakukan manajemen laba sebelum pelaksanaan merger\r\ndan akuisisi. Selain itu bertujuan untuk mengetahui perubahan kinerja keuangan\r\nperusahaan pengakuisisi sebelum dan sesudah merger dan akuisisi.\r\nManajemen laba yang dilakukan oleh perusahaan adalah dengan proksi\r\ndiscretionary accrual (DA). Kemudian untuk pengukuran kinerja perusahaan\r\ndiukur dengan rasio-rasio keuangan meliputi total asset turnover, net profit\r\nmargin, dan return on asset. Analisis dilakukan dengan menggunakan\r\nindependent sample t-test dan paired sample test.\r\nHasil sampel menunjukkan bahwa tidak ada indikasi manajemen laba\r\nsebelum merger dan akuisisi yang dilakukan dengan income increasing accruals.\r\nSelanjutnya kinerja keuangan perusahaan yang diukur dengan rasio total asset\r\nturnover mengalami kenaikan sesudah merger dan akuisisi, sedangkan net profit\r\nmargin dan return on asset mengalami penurunan sesudah merger dan akuisisi.\r\nKata Kunci : merger, akuisisi, manajemen laba, kinerja', 'Tersedia', '2016-01-31', '2016-01-31', 'upload_file/skp0004.pdf', ''),
('skp0005', 'lib001', 'IMPLEMENTASI METODE HEURISTIC ANTIVIRUS DALAM MENDETEKSI MALICIOUS EXECUTABLES', 'PG0055', 'PT0002', 'ksi0004', 'SJ0048', 2014, '2339-210X', 'Teknik Informatika', 'Antivirus adalah sebuah jenis perangkat lunak yang digunakan untuk mengamankan, mendeteksi, dan\r\nmenghapus virus komputer dari sistem komputer. Antivirus disebut juga Virus Protection Software. Aplikasi ini\r\ndapat menentukan apakah sebuah sistem komputer telah terinfeksi dengan sebuah virus atau tidak. Umumnya,\r\nperangkat lunak ini berjalan di latar belakang (background) dan melakukan pemindaian terhadap semua berkas\r\nyang diakses (dibuka, dimodifikasi, atau ketika disimpan).\r\nPenelitian ini bertujuan untuk mengetahui tingkah laku dari virus dan worm. mengetahui bagianbagian\r\napa saja dari sebuah sistem operasi (windows) yang di serang oleh virus dan worm. Membuat sebuah\r\nanti virus sendiri.\r\nMetode lain yang dapat dipakai user adalah metode heuristik. Pada metode ini program akan\r\nmenganggap suatu file adalah virus jika file tersebut mempunyai sifat seperti sifat virus (misalnya merubah nilai\r\nregistry dan memasuki program start up system).\r\nKata Kunci : Antivirus, Metode Heuristic Antivirus Dalam Mendeteksi Malicious Executables.', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/skp0005.pdf', ''),
('skp0006', 'lib001', 'PERANAN AUDIT MANAJEMEN FUNGSI PEMASARAN UNTUK MENCIPTAKAN EFEKTIVITAS DAN EFISIENSI PEMASARAN', 'PG0056', 'PT0041', 'ksi0032', 'SJ0049', 2005, '', 'Manajemen', 'Audit manajemen fungsi pemasaran adalah suatu alat yang tangguh untuk\r\nrnengungkapkan masalah yang dihadapi manajemen pemasaran. Audit pemasaran\r\nmemiliki fungsi utama untuk menguji dan menilai tujuan dan kebisakan\r\npemasaran yang mengarah pada perusahaan. Audit manajemen fungsi pemasaran\r\ndiharapkan dapat ~nemberikanre komcndasi untuk memperbaiki kinerja pemasaran\r\npen~sahaan dalam ha1 yang berkaitan dengan penciptaan efisiensi dan efektivitas\r\nker.ja pemasaran.\r\nUntuk dapat memberikan rekomendasi yang berguna maka beberapa ha1\r\nyang mcn.jadi lingkup dalam audit manajemen fungsi pemasaran adalah\r\npengadaaan analisis pasar yang terus menerus atas sclera dan preferensi pelanggan\r\ndan perubahan di dalam pasar dan karakteristik pelanggan, pengembangkan\r\nstrategi pemasaran khusus dan pengevaluasian kemungkinan produk baru, serta\r\npengadaaan strategi pernasaran sebagai pendukung proyeksi penjualan Jangka\r\npendek dan panjang.\r\nAudit manajemen fungsi pinasaran akan memberikan penilaian sesuai\r\ndengan panduan yang tercakup dalam lingkupnya, apakah kegiatan pemasaran\r\nyang dilakukan oleh perusahaan sudah berjalan dengan semestinya atau tidak.\r\nDari pcnilaian yang dilakukan akan didapatkan informasi mengenai langkahlangkah\r\npcrbaikan yang harus dilakukan untuk menciptakan efektivitas dan\r\nefisiensi pemasaran yang lebih dari sekarang.', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/skp0006.pdf', ''),
('skp0007', 'lib001', 'UPAYA-UPAYA  YANG DILAKUKAN  TELEVISI REPUBLIK INDONESIA  STASIUN BANDUNG DALAM MENJARING PEMASANG IKLAN ', 'PG0058', 'PT0043', 'ksi0034', 'SJ0051', 2003, '', 'Ilmu Komunikasi', 'Yogie Trihandoko Sugiyo, 2003. Laporan tugas akhir ini berjudul, â€œUpaya-upaya yang dilakukan Perusahaan Jawatan TVRI Bandung dalam menjaring pemasang iklanâ€. Pengamatan dilakukan di Perjan TVRI Bandung di bawah bimbingan Drs. Hadi Suprapto Arifin, M. Si. sebagai dosen pembimbing.\r\nPembuatan tugas akhir bertujuan untuk mengetahui dan memperoleh gambaran tentang bauran pemasaran yang dikembangkan dan tentang kegiatan komunikasi pemasaran di TVRI Bandung dalam rangka menjaring pemasang iklan.\r\nMetode yang digunakan dalam penulisan ini adalah metode deskriptif dan teknik pengumpulan data dilakukan dengan cara observasi, wawancara dan studi literatur.\r\nBerdasarkan hasil pengamatan dapat dilihat, upaya-upaya yang dilakukan TVRI Bandung dalam rangka menjaring pemasang iklan, dilakukan oleh satuan kerja Pemasaran dan Program. Upaya-upaya tersebut adalah dengan mengemas suatu bentuk penawaran dengan mempertimbangkan aspek-aspek, yaitu program acara, harga dan jenis iklan serta jangkauan siaran yang dimiliki oleh TVRI Bandung, yang kemudian dipasarkan melalui kegiatan-kegiatan komunikasi pemasaran yaitu periklanan dan penjualan tatap muka.\r\n', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/skp0007.zip', ''),
('skp0008', 'lib001', 'TANGGAPAN MAHASISWA ILMU KOMUNIKASI UNIVERSITAS HASANUDDIN TERHADAP TABLOID IDENTITAS', 'PG0057', 'PT0042', 'ksi0035', 'SJ0050', 2013, '', 'Ilmu Komunikasi', 'RACHEL PRISCELLA SIRIWA. Tanggapan Mahasiswa Ilmu Komunikasi Universitas Hasanuddin Terhadap Tabloid Identitas. (Dibimbing oleh Muhammad Farid dan Abdul Gafar).\r\nTujuan penelitian ini adalah: (1) Untuk mengetahui tanggapan mahasiswa Ilmu Komunikasi Universitas Hasanuddin terhadap desain grafis tabloid Identitas. (2) Untuk mengetahui tanggapan mahasiswa Ilmu Komunikasi Universitas Hasanuddin terhadap berita tabloid Identitas. (3) Untuk mengetahui tanggapan mahasiswa Ilmu Komunikasi Universitas Hasanuddin terhadap iklan tabloid Identitas\r\nPenelitian ini dilakukan selama tiga bulan, dari bulan Juni hingga September 2013 di Jurusan Ilmu Komunikasi Universitas Hasanuddin. Populasi penelitian ini adalah Mahasiswa Ilmu Komunikasi Universitas Hasanuddin. Responden penelitian ditentukan secara Proportional Stratified Sampling. Tipe penelitian menggunakan kuantitatif dengan pendekatan deskriptif.\r\nData primer dikumpulkan dengan menggunakan kuesioner dan data sekundernya dikumpulkanmelalui observasi, studi pustaka, serta melakukan wawancara dengan pihak-pihak terkait dengan penelitian. Data yang dikumpulkan disajikan dalam bentuk tabel frekuensi dan dianalisis secara kuantitatif deskriptif.\r\nHasil penelitian menunjukkan bahwa sebagian besar responden memberikan tanggapan bagus (positif) pada desain grafis dan berita pada tabloid Identitas, sedangkan tanggapan yang kurang bagus (negatif) pada iklan pada tabloid Identitas.', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/skp0008.doc', ''),
('skp0009', 'lib001', 'PENGARUH KEWAJIBAN KEPEMILIKAN NPWP, PEMERIKSAAN PAJAK DAN PENAGIHAN PAJAK TERHADAP PENERIMAAN PAJAK (Pada Kantor Pelayanan Pajak Pratama di Wilayah Jakarta Selatan)', 'PG0059', 'PT0044', 'ksi0036', 'SJ0052', 2013, '', 'Akuntansi', 'Penelitian ini bertujuan untuk menganalisis pengaruh kewajiban\r\nkepemilikan NPWP, pemeriksaan pajak, dan penagihan pajak terhadap\r\npenerimaan pajak. Responden dalam penelitian ini adalah para pegawai pajak\r\n(fiskus) di KPP Pratama wilayah Jakarta Selatan. Jumlah pegawai pajak yang\r\nmenjadi sampel penelitian ini adalah 70 pegawai pajak dari tiga Kantor Pelayanan\r\nPajak Pratama di wilayah Jakarta Selatan. Metode penentuan sampel yang\r\ndigunakan dalam penelitian adalah convenience sampling, sedangkan metode\r\npengolahan data yang digunakan adalah analisis regresi berganda.\r\nHasil penelitian menunjukkan bahwa kewajiban kepemilikan NPWP,\r\npemeriksaan pajak dan penagihan pajak terbukti berpengaruh positif signifikan\r\nterhadap penerimaan pajak. Variabel yang mempunyai pengaruh paling signifikan\r\nterhadap penerimaan pajak adalah penagihan pajak dengan nilai beta yang paling\r\nbesar diantara variabel independen lainnya sebesar (0,305). Penelitian ini\r\nmendukung penelitian yang dilakukan oleh Syahab dan Gisijanto (2008) dan Titin\r\nVegirawati (2011).\r\nKata Kunci : Kewajiban kepemilikan NPWP, pemeriksaan pajak, penagihan\r\npajak dan penerimaan pajak', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/skp0009.doc', ''),
('skp0010', 'lib001', 'ANALISA DAN PERANCANGAN SISTEM PENGISIAN FORMULIR RENCANA STUDI SECARA ONLINE DI STIMIK PERBANAS ', 'PG0060', 'PT0045', 'ksi0004', 'SJ0053', 2013, '', 'Manajemen Informatika', 'Dalam dunia pendidikan, proses pengisian Formulir Rencana Studi adalah kegiatan\r\nrutin yang selalu dilakukan di awal tahun. Sejak awal, pengisian Formulir Rencana Studi\r\ntersebut menggunakan sistem manual, dimana mahasiswa harus mengambil formulir\r\ntersebut pada bagian pendidikan, kemudian mengisikan formulir tersebut secara manual,\r\nmeminta persetujuan dosen pembimbing akademik, lalu kemudian melakukan pengesahan\r\ndi loket pengesahan. Oleh para mahasiswa, proses ini dirasakan sangat mengganggu, karena\r\nmenghabiskan waktu yang cukup banyak, dan selain itu mahasiswa menjadi sangat lelah,\r\nkarena harus mengantri di loket-loket pengesahan.\r\n Dengan mulai berkembangnya dunia teknologi, khususnya teknologi berbasiskan\r\nweb, proses pengisian Formulir Rencana Studi dapat dipermudah. Dengan menggunakan\r\nteknologi server side scripting (program yang semua prosesnya dilakukan di server), dapat\r\ndibuat sebuah aplikasi online untuk membantu mempermudah mahasiswa dalam proses\r\npengisian Formulir Rencana Studi, dimana dengan sistem ini, proses pengisian Formulir\r\nRencana Studi dapat dibuat menjadi lebih baik.\r\n Tugas akhir ini membahas mengenai proses analisa dan perancangan dalam\r\nmembuat sebuah program online berbasiskan web, untuk membantu dalam proses\r\npengisian Formulir Rencana Studi. ', 'Tersedia', '2016-01-31', '0000-00-00', 'upload_file/skp0010.rar', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subjek_buku`
--

CREATE TABLE IF NOT EXISTS `subjek_buku` (
  `kd_subjek` varchar(20) NOT NULL,
  `subjek_utama` varchar(50) NOT NULL,
  `subjek_tambahan` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `subjek_buku`
--

INSERT INTO `subjek_buku` (`kd_subjek`, `subjek_utama`, `subjek_tambahan`, `keterangan`) VALUES
('SJ0001', 'Sistem Pakar', '', ''),
('SJ0002', 'Jaringan Komputer', '', ''),
('SJ0003', 'Manajemen Proyek', '', ''),
('SJ0004', 'Sistem Pendukung Keputusan', 'Simple Additive Weighting (SAW)', ''),
('SJ0005', 'Jaringan', 'Aplikasi', ''),
('SJ0006', 'Jaringan', 'VPN', ''),
('SJ0007', 'UML', '', ''),
('SJ0008', 'TuneUp Utilities 2008', '', ''),
('SJ0009', 'Multimedia', '', ''),
('SJ0010', 'Komputer', 'Pemrograman', ''),
('SJ0011', 'Bahasa Inggris', 'Kosa kata', ''),
('SJ0012', 'Novel', '', ''),
('SJ0013', 'Bahasa Inggris', '', ''),
('SJ0014', 'Ilmu Komunikasi', '', ''),
('SJ0015', 'Ilmu Budaya', '', ''),
('SJ0016', 'Micro Economics', '', ''),
('SJ0017', 'Ekonomi', '', ''),
('SJ0018', 'Perpajakan', '', ''),
('SJ0019', 'Auditing Akuntan', '', ''),
('SJ0020', 'Akuntansi', '', ''),
('SJ0021', 'Kamus', 'Istilah Akuntansi', ''),
('SJ0022', 'Komunikasi', '', ''),
('SJ0023', 'Etika', 'Kehumasan', ''),
('SJ0024', 'Sosiologi', 'Komunikasi', ''),
('SJ0025', 'Antropologi', '', ''),
('SJ0026', 'Komunikasi', 'Propaganda', ''),
('SJ0027', 'Komunikasi', 'Ilmu', ''),
('SJ0028', 'Prosedur Penelitian', '', ''),
('SJ0029', 'Ekonomi', 'Manajemen', ''),
('SJ0030', 'Manajemen', '', ''),
('SJ0031', 'Manajemen Bisnis', 'Microsoft Excel', ''),
('SJ0032', 'Manajemen', 'Bisnis', ''),
('SJ0033', 'Manajemen', 'Penerbitan Pers', ''),
('SJ0034', 'Manajemen', 'Ekonomi Mikro', ''),
('SJ0035', 'Ekonomi', 'Mikro', ''),
('SJ0036', 'Bahasa Inggris', 'Basic Grammar', ''),
('SJ0037', 'Bahasa Inggris', 'Fiksi', ''),
('SJ0038', 'Bahasa Inggris', 'Menulis', ''),
('SJ0039', 'Bahasa', 'Sintaksis', ''),
('SJ0040', 'Ensiklopedia', 'Biografi', ''),
('SJ0041', 'Komputer', 'Interaksi Manusia dan Komputer', ''),
('SJ0042', 'Sistem Operasi', '', ''),
('SJ0043', 'Struktur Data', 'Pascal', ''),
('SJ0044', 'Auxiliary Verbs', '', ''),
('SJ0045', 'Sosiolinguistik', '', ''),
('SJ0046', 'Penelitian Pemasaran', '', ''),
('SJ0047', 'Manajemen Laba', 'Merger dan Akuisisi', ''),
('SJ0048', 'Antivirus', 'Metode Heuristic Antivirus Dalam Mendeteksi Malici', ''),
('SJ0049', 'Audit Manajemen', 'Pemasaran', ''),
('SJ0050', 'Media Berita', 'Tabloid', ''),
('SJ0051', 'Media TV', '', ''),
('SJ0052', 'Perpajakan', 'NPWP', ''),
('SJ0053', 'Pemrograman', '', ''),
('SJ0054', 'Akuntan', '', ''),
('SJ0055', 'ERC (Earning Response Coefficient)', '', ''),
('SJ0056', 'EARNINGS RESPONSE COEFFICIENT (ERC)', '', ''),
('SJ0057', 'Kepuasan Kerja', '', ''),
('SJ0058', 'Financial Distress Hypothesis', '', ''),
('SJ0059', 'Pelayanan Perusahaan', '', ''),
('SJ0060', 'Komunikasi Informasi', '', ''),
('SJ0061', 'Sistem Informasi', 'PHP', ''),
('SJ0062', 'Pengendalian Intern', 'Laporan Keuangan', ''),
('SJ0063', 'Prosedur Perpajakan', '', ''),
('SJ0064', 'Laporan Keuangan Pemerintah', '', ''),
('SJ0065', 'Moral Masyarakat', 'Surat Kabar', ''),
('SJ0066', 'Komunikasi NGO', '', ''),
('SJ0067', 'Pers', '', ''),
('SJ0068', 'Jurnalisme', '', ''),
('SJ0069', 'Literaly Translation', '', ''),
('SJ0070', 'Metafora', '', ''),
('SJ0071', 'Bahasa', 'SOSIO-PSIKOLINGUISTIK', ''),
('SJ0072', 'Penerjemahan', 'Analisis Fungsional', ''),
('SJ0073', 'Budaya Organisasi', 'Kinerja Karyawan', ''),
('SJ0074', 'E-commerce', '', ''),
('SJ0075', 'Jurnal Online', '', ''),
('SJ0076', 'Web Application', '', ''),
('SJ0077', 'Android', 'Media Pembelajaran', ''),
('SJ0078', 'Sistem Informasi', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`kd_mem`,`kd_petugas`),
  ADD KEY `kd_petugas` (`kd_petugas`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kd_buku`,`kd_petugas`,`kd_pengarang`,`kd_penerbit`,`kd_subjek`,`kd_klasifikasi`,`kd_sirkulasi`),
  ADD KEY `kd_sirkulasi` (`kd_sirkulasi`),
  ADD KEY `kd_pengarang` (`kd_pengarang`),
  ADD KEY `kd_penerbit` (`kd_penerbit`),
  ADD KEY `kd_subjek` (`kd_subjek`),
  ADD KEY `kd_pustakawan` (`kd_petugas`),
  ADD KEY `kd_klasifikasi` (`kd_klasifikasi`);

--
-- Indexes for table `detail_pinjam`
--
ALTER TABLE `detail_pinjam`
  ADD PRIMARY KEY (`kd_pinjam`,`kd_buku`),
  ADD KEY `kd_buku` (`kd_buku`);

--
-- Indexes for table `download_ebook`
--
ALTER TABLE `download_ebook`
  ADD PRIMARY KEY (`kd_ebook`);

--
-- Indexes for table `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`kd_ebook`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`kd_jurnal`,`kd_petugas`,`kd_penulis`,`kd_penerbit`,`kd_klasifikasi`,`kd_subjek`),
  ADD KEY `kd_penulis` (`kd_penulis`),
  ADD KEY `kd_penerbit` (`kd_penerbit`),
  ADD KEY `kd_petugas` (`kd_petugas`),
  ADD KEY `kd_subjek` (`kd_subjek`),
  ADD KEY `kd_klasifikasi` (`kd_klasifikasi`);

--
-- Indexes for table `kalender_unpi`
--
ALTER TABLE `kalender_unpi`
  ADD PRIMARY KEY (`kd_libur`);

--
-- Indexes for table `klasifikasi_buku`
--
ALTER TABLE `klasifikasi_buku`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `kp`
--
ALTER TABLE `kp`
  ADD PRIMARY KEY (`kd_kp`,`kd_petugas`,`kd_penulis`,`kd_penerbit`,`kd_klasifikasi`,`kd_subjek`),
  ADD KEY `kd_penulis` (`kd_penulis`),
  ADD KEY `kd_petugas` (`kd_petugas`),
  ADD KEY `kd_penerbit` (`kd_penerbit`),
  ADD KEY `kd_subjek` (`kd_subjek`),
  ADD KEY `kd_klasifikasi` (`kd_klasifikasi`);

--
-- Indexes for table `makalah`
--
ALTER TABLE `makalah`
  ADD PRIMARY KEY (`kd_makalah`,`kd_petugas`,`kd_penulis`,`kd_penerbit`,`kd_klasifikasi`,`kd_subjek`),
  ADD KEY `kd_penulis` (`kd_penulis`),
  ADD KEY `kd_petugas` (`kd_petugas`),
  ADD KEY `kd_penerbit` (`kd_penerbit`),
  ADD KEY `kd_subjek` (`kd_subjek`),
  ADD KEY `kd_klasifikasi` (`kd_klasifikasi`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`kd_pinjam`,`kd_petugas`,`kd_member`),
  ADD KEY `kd_member` (`kd_member`),
  ADD KEY `kd_pustakawan` (`kd_petugas`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`kd_penerbit`);

--
-- Indexes for table `pengarang`
--
ALTER TABLE `pengarang`
  ADD PRIMARY KEY (`kd_pengarang`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`kd_petugas`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`kd_req`),
  ADD KEY `kd_member` (`kd_pengaju`);

--
-- Indexes for table `sirkulasi`
--
ALTER TABLE `sirkulasi`
  ADD PRIMARY KEY (`kd_sirkulasi`);

--
-- Indexes for table `skripsi`
--
ALTER TABLE `skripsi`
  ADD PRIMARY KEY (`kd_skripsi`,`kd_petugas`,`kd_penulis`,`kd_penerbit`,`kd_klasifikasi`,`kd_subjek`),
  ADD KEY `kd_penulis` (`kd_penulis`),
  ADD KEY `kd_klasifikasi` (`kd_klasifikasi`),
  ADD KEY `kd_subjek` (`kd_subjek`),
  ADD KEY `kd_petugas` (`kd_petugas`),
  ADD KEY `kd_penerbit` (`kd_penerbit`);

--
-- Indexes for table `subjek_buku`
--
ALTER TABLE `subjek_buku`
  ADD PRIMARY KEY (`kd_subjek`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kalender_unpi`
--
ALTER TABLE `kalender_unpi`
  MODIFY `kd_libur` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`kd_petugas`) REFERENCES `petugas` (`kd_petugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`kd_sirkulasi`) REFERENCES `sirkulasi` (`kd_sirkulasi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`kd_pengarang`) REFERENCES `pengarang` (`kd_pengarang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`kd_penerbit`) REFERENCES `penerbit` (`kd_penerbit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_ibfk_5` FOREIGN KEY (`kd_subjek`) REFERENCES `subjek_buku` (`kd_subjek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_ibfk_6` FOREIGN KEY (`kd_petugas`) REFERENCES `petugas` (`kd_petugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_ibfk_7` FOREIGN KEY (`kd_klasifikasi`) REFERENCES `klasifikasi_buku` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pinjam`
--
ALTER TABLE `detail_pinjam`
  ADD CONSTRAINT `detail_pinjam_ibfk_1` FOREIGN KEY (`kd_pinjam`) REFERENCES `peminjaman` (`kd_pinjam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pinjam_ibfk_2` FOREIGN KEY (`kd_buku`) REFERENCES `buku` (`kd_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`kd_penulis`) REFERENCES `pengarang` (`kd_pengarang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_ibfk_2` FOREIGN KEY (`kd_penerbit`) REFERENCES `penerbit` (`kd_penerbit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_ibfk_3` FOREIGN KEY (`kd_petugas`) REFERENCES `petugas` (`kd_petugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_ibfk_4` FOREIGN KEY (`kd_subjek`) REFERENCES `subjek_buku` (`kd_subjek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_ibfk_5` FOREIGN KEY (`kd_klasifikasi`) REFERENCES `klasifikasi_buku` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `makalah`
--
ALTER TABLE `makalah`
  ADD CONSTRAINT `makalah_ibfk_1` FOREIGN KEY (`kd_penulis`) REFERENCES `pengarang` (`kd_pengarang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `makalah_ibfk_2` FOREIGN KEY (`kd_petugas`) REFERENCES `petugas` (`kd_petugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `makalah_ibfk_3` FOREIGN KEY (`kd_penerbit`) REFERENCES `penerbit` (`kd_penerbit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `makalah_ibfk_4` FOREIGN KEY (`kd_subjek`) REFERENCES `subjek_buku` (`kd_subjek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `makalah_ibfk_5` FOREIGN KEY (`kd_klasifikasi`) REFERENCES `klasifikasi_buku` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`kd_member`) REFERENCES `anggota` (`kd_mem`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`kd_petugas`) REFERENCES `petugas` (`kd_petugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `skripsi`
--
ALTER TABLE `skripsi`
  ADD CONSTRAINT `skripsi_ibfk_1` FOREIGN KEY (`kd_penulis`) REFERENCES `pengarang` (`kd_pengarang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skripsi_ibfk_2` FOREIGN KEY (`kd_klasifikasi`) REFERENCES `klasifikasi_buku` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skripsi_ibfk_3` FOREIGN KEY (`kd_subjek`) REFERENCES `subjek_buku` (`kd_subjek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skripsi_ibfk_4` FOREIGN KEY (`kd_petugas`) REFERENCES `petugas` (`kd_petugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skripsi_ibfk_5` FOREIGN KEY (`kd_penerbit`) REFERENCES `penerbit` (`kd_penerbit`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
