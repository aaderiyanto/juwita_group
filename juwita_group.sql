/*
SQLyog Ultimate v10.42 
MySQL - 5.6.14 : Database - juwita_group
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `bmt_asset` */

DROP TABLE IF EXISTS `bmt_asset`;

CREATE TABLE `bmt_asset` (
  `id_asset` varchar(16) NOT NULL COMMENT 'AST',
  `nama_asset` varchar(100) DEFAULT NULL,
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_asset`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_asset` */

insert  into `bmt_asset`(`id_asset`,`nama_asset`,`keterangan`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('AST6CQWJL5C4P492','Kursi Merk B','Kursi pada saat awal adalah sangat baik.','2020-05-08 23:15:16','USR11213453HGTTD','2020-05-08 23:16:18','USR11213453HGTTD'),('ASTB5MMUKGQ8P578','Laptop DELL 14 Inc','sangat baik (2 unit)','2020-05-08 23:15:55','USR11213453HGTTD',NULL,NULL),('ASTMQ879X8SWS167','PC Komputer','-','2020-05-08 23:15:28','USR11213453HGTTD',NULL,NULL),('ASTX7EGD94GRD437','Meja Merk A','Kondisi awal meja adalah baik.','2020-05-08 23:14:55','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `bmt_boq` */

DROP TABLE IF EXISTS `bmt_boq`;

CREATE TABLE `bmt_boq` (
  `id_boq` varchar(16) NOT NULL COMMENT 'BOQ...',
  `nomor_order` varchar(30) DEFAULT NULL COMMENT 'BOQ/2006/0001',
  `nomor_po` varchar(50) DEFAULT NULL,
  `id_vendor` varchar(16) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `flag_data` smallint(1) DEFAULT '2' COMMENT '1=oke,2=pending, 0=tolak',
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_boq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_boq` */

/*Table structure for table `bmt_boq_detail` */

DROP TABLE IF EXISTS `bmt_boq_detail`;

CREATE TABLE `bmt_boq_detail` (
  `id_boq_detail` varchar(16) NOT NULL COMMENT 'BQD',
  `id_boq` varchar(16) DEFAULT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `jumlah` double DEFAULT '1',
  `nominal` double DEFAULT '0',
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_boq_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_boq_detail` */

/*Table structure for table `bmt_info_asset` */

DROP TABLE IF EXISTS `bmt_info_asset`;

CREATE TABLE `bmt_info_asset` (
  `id_infoasset` varchar(16) NOT NULL COMMENT 'IAS',
  `id_asset` varchar(16) DEFAULT NULL,
  `jenis_asset` varchar(20) DEFAULT 'kantin' COMMENT 'kantin, gudang',
  `tanggal` date DEFAULT NULL,
  `kondisi` varchar(30) DEFAULT NULL COMMENT 'baik,rusak,hilang',
  `keterangan` text,
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=aktif,0=tdk aktif',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_infoasset`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_info_asset` */

insert  into `bmt_info_asset`(`id_infoasset`,`id_asset`,`jenis_asset`,`tanggal`,`kondisi`,`keterangan`,`flag_aktif`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('IASB53CM4RTAC483','ASTB5MMUKGQ8P578','kantin','2020-05-08','Baik','oke',1,'2020-05-08 23:42:10','USR11213453HGTTD',NULL,NULL),('IASDEM3XFFB66389','AST6CQWJL5C4P492','gudang','2020-05-01','Baik','oke',1,'2020-05-08 23:37:31','USR11213453HGTTD','2020-05-08 23:40:11','USR11213453HGTTD');

/*Table structure for table `bmt_manufacture` */

DROP TABLE IF EXISTS `bmt_manufacture`;

CREATE TABLE `bmt_manufacture` (
  `id_manufacture` varchar(16) NOT NULL COMMENT 'MAN...',
  `nama_produk` varchar(250) DEFAULT NULL,
  `jumlah` double DEFAULT '1',
  `id_vendor` varchar(16) DEFAULT NULL,
  `nomor_mo` varchar(20) DEFAULT NULL COMMENT 'MO/2006/0001',
  `tgl_buat` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `flag_data` smallint(1) DEFAULT '2' COMMENT '2=pending, 3=dalam proses, 1=selesai, 0=batal',
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_manufacture`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_manufacture` */

insert  into `bmt_manufacture`(`id_manufacture`,`nama_produk`,`jumlah`,`id_vendor`,`nomor_mo`,`tgl_buat`,`tgl_selesai`,`flag_data`,`keterangan`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('MAN98EK7PS5R8JWA','Beton tiang listrik 4M',1000,'VNDJ7YXXLBQ6T340','MO/2006/0001','2020-06-24','2020-07-31',1,'Isikan keterangan data oke','2020-06-24 00:17:22','USR11213453HGTTD','2020-07-01 11:52:15','USR11213453HGTTD');

/*Table structure for table `bmt_manufacture_detail` */

DROP TABLE IF EXISTS `bmt_manufacture_detail`;

CREATE TABLE `bmt_manufacture_detail` (
  `id_manufacture_detail` varchar(16) NOT NULL COMMENT 'MOD',
  `id_manufacture` varchar(16) DEFAULT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `jumlah` double DEFAULT '1',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_manufacture_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_manufacture_detail` */

insert  into `bmt_manufacture_detail`(`id_manufacture_detail`,`id_manufacture`,`id_produk`,`jumlah`,`tgl_input`,`user_input`) values ('MOD3FB95NUW7YKGF','MAN98EK7PS5R8JWA','PRDB37GPHR8RQB3YR840',100,'2020-07-01 11:52:15','USR11213453HGTTD'),('MOD3QM89AXGUUQWT','MAN98EK7PS5R8JWA','PRD3TD54AREWLQMHS624',300,'2020-07-01 11:52:15','USR11213453HGTTD'),('MODVN7YABKFC9D8W','MAN98EK7PS5R8JWA','PRDHXMWBVFN39YJR8917',200,'2020-07-01 11:52:15','USR11213453HGTTD');

/*Table structure for table `bmt_manufacture_dokumen` */

DROP TABLE IF EXISTS `bmt_manufacture_dokumen`;

CREATE TABLE `bmt_manufacture_dokumen` (
  `id_dokumen` int(11) NOT NULL AUTO_INCREMENT,
  `id_manufacture` varchar(16) DEFAULT NULL,
  `nama_dokumen` varchar(100) DEFAULT NULL,
  `file` varchar(50) DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_dokumen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_manufacture_dokumen` */

/*Table structure for table `bmt_user` */

DROP TABLE IF EXISTS `bmt_user`;

CREATE TABLE `bmt_user` (
  `id_user` varchar(16) NOT NULL COMMENT 'USR...',
  `nama` varchar(150) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level` varchar(30) DEFAULT 'cashier',
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=bolh login,0=tdk',
  `foto` varchar(50) DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bmt_user` */

insert  into `bmt_user`(`id_user`,`nama`,`username`,`password`,`level`,`flag_aktif`,`foto`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('USR11213453HGTTD','SUPER ADMINISTRATOR','admin','d033e22ae348aeb5660fc2140aec35850c4da997','admin',1,NULL,'2019-09-29 14:26:28','USR11213453HGTTD','2020-05-10 11:03:52','USR11213453HGTTD'),('USR7CMRTKV9UU416','EKKA MUSTIKA','administrasi','7c4a8d09ca3762af61e59520943dc26494f8941b','administrasi',1,NULL,'2020-05-10 11:01:23','USR11213453HGTTD',NULL,NULL),('USRQFAMERKRXW943','EKKA MUSTIKA','pimpinan','7c4a8d09ca3762af61e59520943dc26494f8941b','pimpinan',1,NULL,'2020-05-10 11:02:59','USR11213453HGTTD',NULL,NULL),('USRVBTG4KJRLN417','EKKA MUSTIKA','gudang','7c4a8d09ca3762af61e59520943dc26494f8941b','gudang',1,NULL,'2020-05-10 11:02:08','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `finance_akun` */

DROP TABLE IF EXISTS `finance_akun`;

CREATE TABLE `finance_akun` (
  `id_akun` smallint(5) NOT NULL AUTO_INCREMENT,
  `jenis_akun` varchar(20) DEFAULT NULL COMMENT 'bank, kas',
  `nama_akun` varchar(50) DEFAULT NULL,
  `rekening` varchar(50) DEFAULT NULL,
  `saldo` double DEFAULT '0',
  `debit` double DEFAULT '0',
  `kredit` double DEFAULT '0',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_akun`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `finance_akun` */

insert  into `finance_akun`(`id_akun`,`jenis_akun`,`nama_akun`,`rekening`,`saldo`,`debit`,`kredit`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values (1,'cash','Akun Cash','-',0,0,0,'2020-05-06 09:09:53','USR11213453HGTTD','2020-05-06 09:10:43','USR11213453HGTTD'),(2,'bank','Bank Mandiri','1122112211001',7850000,8000000,150000,'2020-05-06 09:10:31','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `finance_kategori` */

DROP TABLE IF EXISTS `finance_kategori`;

CREATE TABLE `finance_kategori` (
  `id_katfinance` varchar(16) NOT NULL COMMENT 'KFN',
  `kategori` varchar(50) DEFAULT NULL,
  `flag_aktif` smallint(1) DEFAULT '1',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_katfinance`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `finance_kategori` */

insert  into `finance_kategori`(`id_katfinance`,`kategori`,`flag_aktif`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('KFN6WR3NLFKN3707','Uang BBM',1,'2020-05-08 15:16:17','USR11213453HGTTD','2020-05-08 15:16:25','USR11213453HGTTD'),('KFNKTLLD39GAK685','Uang Makan',1,'2020-05-08 15:16:10','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `finance_transaksi` */

DROP TABLE IF EXISTS `finance_transaksi`;

CREATE TABLE `finance_transaksi` (
  `id_ft` varchar(16) NOT NULL COMMENT 'TRN',
  `jenis_data` enum('d','k') DEFAULT NULL COMMENT 'd=pemasukan,k=pengeluaran',
  `id_katfinance` varchar(16) DEFAULT NULL,
  `id_akun` smallint(5) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `no_transaksi` varchar(30) DEFAULT NULL,
  `nominal` double DEFAULT '0',
  `keterangan` text,
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=aktif,0=tdk aktif',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_ft`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `finance_transaksi` */

insert  into `finance_transaksi`(`id_ft`,`jenis_data`,`id_katfinance`,`id_akun`,`tgl_transaksi`,`no_transaksi`,`nominal`,`keterangan`,`flag_aktif`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('TRNBCNGDF3LK9Q74','k','KFN6WR3NLFKN3707',2,'2020-05-08','TR-K/2005/0001',50000,'ok',1,'2020-05-08 16:00:17','USR11213453HGTTD',NULL,NULL),('TRNC7CMD6SEWRTXY','d','KFNKTLLD39GAK685',2,'2020-05-08','TR-D/2005/0001',2000000,'ok',1,'2020-05-08 15:42:19','USR11213453HGTTD',NULL,NULL),('TRNNY3YDXC4ECNLL','d','KFN6WR3NLFKN3707',2,'2020-05-07','TR-D/2005/0002',6000000,'ok',1,'2020-05-08 15:42:48','USR11213453HGTTD',NULL,NULL),('TRNSMUAJGULYAW4A','k','KFNKTLLD39GAK685',2,'2020-05-07','TR-K/2005/0002',100000,'ok',1,'2020-05-08 16:02:33','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `gudang_pembelian` */

DROP TABLE IF EXISTS `gudang_pembelian`;

CREATE TABLE `gudang_pembelian` (
  `id_gudangpembelian` varchar(20) NOT NULL COMMENT 'GPB',
  `no_invoice` varchar(30) DEFAULT NULL COMMENT 'POS/0420/00001',
  `tgl_invoice` date DEFAULT NULL,
  `total_nominal` double DEFAULT '0',
  `terms` smallint(3) DEFAULT '0',
  `batas_tempo` date DEFAULT NULL,
  `bill_to` varchar(16) DEFAULT NULL COMMENT 'client/vendor',
  `flag_ppn` smallint(1) DEFAULT '1' COMMENT '1=kena ppn,0=tidak',
  `flag_aktif` smallint(1) DEFAULT '1',
  `auto_inv` smallint(1) DEFAULT '1' COMMENT '1=otomatis no invoice',
  `flag_lunas` smallint(1) DEFAULT '1',
  `tgl_lunas` date DEFAULT NULL,
  `keterangan` text,
  `id_po` varchar(16) DEFAULT NULL COMMENT 'lookup pos_po untuk pembelian',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_gudangpembelian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `gudang_pembelian` */

insert  into `gudang_pembelian`(`id_gudangpembelian`,`no_invoice`,`tgl_invoice`,`total_nominal`,`terms`,`batas_tempo`,`bill_to`,`flag_ppn`,`flag_aktif`,`auto_inv`,`flag_lunas`,`tgl_lunas`,`keterangan`,`id_po`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('GPB7HWLCQMX3JQKD4828','PMB/2005/0002','2020-05-10',21164000,7,'2020-05-17','VNDJ7YXXLBQ6T340',1,1,1,1,'2020-05-10','sip bos ku...','PPOKRAB7UPF5CXW7','2020-05-10 21:48:19','USRVBTG4KJRLN417','2020-05-10 21:50:02','USRVBTG4KJRLN417'),('GPBPN6K8K9PXG6MET714','PMB/2005/0001','2020-05-07',4180000,7,'2020-05-14','VND3X67ALY7XX493',1,1,1,1,'2020-05-08','-','PPOV9GX9WYCNHXQA','2020-05-07 12:48:42','USR11213453HGTTD','2020-05-08 23:00:09','USR11213453HGTTD');

/*Table structure for table `gudang_pembelian_cicilan` */

DROP TABLE IF EXISTS `gudang_pembelian_cicilan`;

CREATE TABLE `gudang_pembelian_cicilan` (
  `id_pembcicilan` varchar(20) NOT NULL COMMENT 'PMC',
  `id_gudangpembelian` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nominal` double DEFAULT '0',
  `id_akun` smallint(6) DEFAULT NULL,
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=aktif,0=tdk aktif',
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_pembcicilan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `gudang_pembelian_cicilan` */

/*Table structure for table `gudang_pembelian_detail` */

DROP TABLE IF EXISTS `gudang_pembelian_detail`;

CREATE TABLE `gudang_pembelian_detail` (
  `id_pembdetail` varchar(20) NOT NULL COMMENT 'PMD',
  `id_gudangpembelian` varchar(20) DEFAULT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `jumlah` smallint(5) DEFAULT '0',
  `nominal` double DEFAULT '0',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_pembdetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `gudang_pembelian_detail` */

insert  into `gudang_pembelian_detail`(`id_pembdetail`,`id_gudangpembelian`,`id_produk`,`jumlah`,`nominal`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('PMD8ARVVYUMEA9M3G769','GPB7HWLCQMX3JQKD4828','PRDHXMWBVFN39YJR8917',2000,9500,'2020-05-10 21:48:20','USRVBTG4KJRLN417',NULL,NULL),('PMDABA5D5S5EPDUXU178','GPBPN6K8K9PXG6MET714','PRDB37GPHR8RQB3YR840',1000,1200,'2020-05-07 12:48:42','USR11213453HGTTD',NULL,NULL),('PMDDW5XSSTCULXG3E554','GPB7HWLCQMX3JQKD4828','PRD3TD54AREWLQMHS624',20,12000,'2020-05-10 21:48:19','USRVBTG4KJRLN417',NULL,NULL),('PMDKBN894D3THWY6W654','GPBPN6K8K9PXG6MET714','PRD3TD54AREWLQMHS624',2000,1300,'2020-05-07 12:48:42','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `pos_brand` */

DROP TABLE IF EXISTS `pos_brand`;

CREATE TABLE `pos_brand` (
  `id_brand` varchar(16) NOT NULL COMMENT 'prefix BRN',
  `brand` varchar(100) DEFAULT NULL,
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=aktif,0=tdk aktif',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_brand`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_brand` */

insert  into `pos_brand`(`id_brand`,`brand`,`flag_aktif`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('BRNABNEFSLVCB427','Besi B',1,'2020-04-19 11:10:28','USR11213453HGTTD','2020-05-11 00:29:25','USR11213453HGTTD'),('BRNH4RCBWJBDN915','ABC',1,'2020-04-19 11:11:24','USR11213453HGTTD',NULL,NULL),('BRNK3YKD7MRQS214','Besi A',1,'2020-04-19 11:10:43','USR11213453HGTTD','2020-05-11 00:29:18','USR11213453HGTTD'),('BRNKDXTQAF8E3443','Besi C',1,'2020-04-19 11:10:12','USR11213453HGTTD','2020-05-11 00:29:49','USR11213453HGTTD'),('BRNXFM8U7G84G401','Besi D',1,'2020-04-19 11:10:23','USR11213453HGTTD','2020-05-11 00:29:44','USR11213453HGTTD');

/*Table structure for table `pos_customer` */

DROP TABLE IF EXISTS `pos_customer`;

CREATE TABLE `pos_customer` (
  `id_customer` varchar(16) NOT NULL COMMENT 'CST',
  `type_customer` varchar(20) DEFAULT 'umum' COMMENT 'umum dan default',
  `nik` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `jenis_kelamin` varchar(15) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_customer` */

/*Table structure for table `pos_kategori_produk` */

DROP TABLE IF EXISTS `pos_kategori_produk`;

CREATE TABLE `pos_kategori_produk` (
  `id_kategori` varchar(16) NOT NULL COMMENT 'prefix KTG',
  `kategori` varchar(100) DEFAULT NULL,
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=aktif,0=tdk aktif',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_kategori_produk` */

insert  into `pos_kategori_produk`(`id_kategori`,`kategori`,`flag_aktif`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('KTGJA3LGH83UB796','Besi',1,'2020-04-19 11:19:55','USR11213453HGTTD','2020-05-11 00:24:46','USR11213453HGTTD'),('KTGSXHGGHHY6N886','Kayu',1,'2020-04-19 11:20:01','USR11213453HGTTD','2020-05-11 00:24:53','USR11213453HGTTD');

/*Table structure for table `pos_po` */

DROP TABLE IF EXISTS `pos_po`;

CREATE TABLE `pos_po` (
  `id_po` varchar(16) NOT NULL COMMENT 'PPO',
  `nomor_po` varchar(20) DEFAULT NULL COMMENT 'PO/2005/0001',
  `tgl_po` date DEFAULT NULL,
  `bill_to` varchar(16) DEFAULT NULL,
  `ship_to` text,
  `nominal` double DEFAULT NULL,
  `flag_ppn` smallint(1) DEFAULT '1',
  `terms` smallint(4) DEFAULT '7',
  `batas_tempo` date DEFAULT NULL,
  `flag_po` smallint(1) DEFAULT '2' COMMENT '2=pending,1=setujui,0=batal',
  `flag_gudang` smallint(1) DEFAULT '0' COMMENT '1=PO gudang,0=PO Kantin',
  `flag_pembelian` smallint(1) DEFAULT '0' COMMENT '1=sudah input pembelian',
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_po`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_po` */

insert  into `pos_po`(`id_po`,`nomor_po`,`tgl_po`,`bill_to`,`ship_to`,`nominal`,`flag_ppn`,`terms`,`batas_tempo`,`flag_po`,`flag_gudang`,`flag_pembelian`,`keterangan`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('PPO7U87W3XFTYVMU','PO/2005/0004','2020-05-08','VNDJ6AWXVGKXX504','PT. AAAA',0,1,7,'2020-05-15',1,0,0,'ok sip','2020-05-08 22:34:53','USR11213453HGTTD','2020-05-08 22:38:51','USR11213453HGTTD'),('PPOGPML7MVSCPBJM','PO/2005/0001','2020-05-05','VNDJ6AWXVGKXX504','PT. AAA',330000,1,7,'2020-05-12',1,0,1,'oke sip.','2020-05-05 09:57:43','USR11213453HGTTD','2020-05-05 23:46:24','USR11213453HGTTD'),('PPOJAJN3C97EUWTT','PO/2005/0005','2020-05-09','VNDJ6AWXVGKXX504','AAAA\r\nlokasi 1',0,1,7,'2020-05-16',2,0,0,NULL,'2020-05-09 15:32:02','USR11213453HGTTD',NULL,NULL),('PPOKRAB7UPF5CXW7','PO/2005/0006','2020-05-09','VND3X67ALY7XX493','Aaaa',21164000,1,7,'2020-05-16',1,1,1,'oke sip','2020-05-09 16:13:01','USR11213453HGTTD','2020-05-10 21:36:13','USR11213453HGTTD'),('PPONX88U7ALLG8GD','PO/2005/0003','2020-05-08','VNDJ6AWXVGKXX504','PT. Gudang AAA\r\nJl. Mawar Melati semua indah',0,1,7,'2020-05-15',1,0,1,'ok sip','2020-05-08 16:39:23','USR11213453HGTTD','2020-05-08 16:39:56','USR11213453HGTTD'),('PPOV9GX9WYCNHXQA','PO/2005/0002','2020-05-07','VND3X67ALY7XX493','PT. Waterboom Pekanbaru Indonesia\r\nJl. Mawar No. 22 Pekanbaru, Riau',4180000,1,7,'2020-05-14',1,1,1,'PO ini silahkan di lanjutkan ke proses input STOK.','2020-05-07 11:49:01','USR11213453HGTTD','2020-05-07 12:00:02','USR11213453HGTTD'),('PPOVNSVS3R37JTQN','PO/2005/0007','2020-05-10','VNDJ7YXXLBQ6T340','PT. AAA\r\nJl. apa aja oke',176000,1,7,'2020-05-17',2,1,0,NULL,'2020-05-10 21:28:46','USRVBTG4KJRLN417','2020-05-10 21:32:31','USRVBTG4KJRLN417');

/*Table structure for table `pos_po_detail` */

DROP TABLE IF EXISTS `pos_po_detail`;

CREATE TABLE `pos_po_detail` (
  `id_podetail` varchar(16) NOT NULL COMMENT 'POD',
  `id_po` varchar(16) DEFAULT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `jumlah` smallint(6) DEFAULT '1',
  `nominal` double DEFAULT '0',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_podetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_po_detail` */

insert  into `pos_po_detail`(`id_podetail`,`id_po`,`id_produk`,`jumlah`,`nominal`,`tgl_input`,`user_input`) values ('PODB48TNC8GGBYXU','PPOJAJN3C97EUWTT','PRDB37GPHR8RQB3YR840',30,0,'2020-05-09 15:32:02','USR11213453HGTTD'),('PODGHSWE39ETTWX9','PPOKRAB7UPF5CXW7','PRD3TD54AREWLQMHS624',20,12000,'2020-05-10 21:36:13','USR11213453HGTTD'),('PODJSJYJRLU8LTEV','PPOGPML7MVSCPBJM','PRDB37GPHR8RQB3YR840',100,1000,'2020-05-05 23:46:24','USR11213453HGTTD'),('PODLLKKAQN865AFM','PPOV9GX9WYCNHXQA','PRD3TD54AREWLQMHS624',2000,1300,'2020-05-07 12:00:02','USR11213453HGTTD'),('PODMMUX7HPYVQ986','PPO7U87W3XFTYVMU','PRDB37GPHR8RQB3YR840',50,0,'2020-05-08 22:38:51','USR11213453HGTTD'),('PODRPP6G3U8GUBBJ','PPO7U87W3XFTYVMU','PRD3TD54AREWLQMHS624',20,0,'2020-05-08 22:38:51','USR11213453HGTTD'),('PODTG9NU9HXQ4HS6','PPOGPML7MVSCPBJM','PRD3TD54AREWLQMHS624',100,2000,'2020-05-05 23:46:24','USR11213453HGTTD'),('PODTM6LYGW9473PP','PPONX88U7ALLG8GD','PRDB37GPHR8RQB3YR840',20,0,'2020-05-08 16:39:56','USR11213453HGTTD'),('PODV4EJ4F7G5F674','PPOV9GX9WYCNHXQA','PRDB37GPHR8RQB3YR840',1000,1200,'2020-05-07 12:00:02','USR11213453HGTTD'),('PODVABF8NKPFHM3N','PPOKRAB7UPF5CXW7','PRDHXMWBVFN39YJR8917',2000,9500,'2020-05-10 21:36:13','USR11213453HGTTD'),('PODWGGYT646B7TVJ','PPOVNSVS3R37JTQN','PRDB37GPHR8RQB3YR840',20,8000,'2020-05-10 21:32:31','USRVBTG4KJRLN417');

/*Table structure for table `pos_po_detail_delete` */

DROP TABLE IF EXISTS `pos_po_detail_delete`;

CREATE TABLE `pos_po_detail_delete` (
  `id_podetail` varchar(16) NOT NULL COMMENT 'POD',
  `id_po` varchar(16) DEFAULT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `jumlah` smallint(6) DEFAULT '1',
  `nominal` double DEFAULT '0',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_podetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_po_detail_delete` */

/*Table structure for table `pos_produk` */

DROP TABLE IF EXISTS `pos_produk`;

CREATE TABLE `pos_produk` (
  `id_produk` varchar(20) NOT NULL COMMENT 'prefix PRD',
  `jenis_data` varchar(20) DEFAULT 'stok' COMMENT 'stok,service',
  `sku` varchar(50) DEFAULT NULL COMMENT 'sku/kode produk',
  `nama_produk` varchar(200) DEFAULT NULL,
  `nominal` double DEFAULT '0' COMMENT 'harga jual',
  `harga_modal` double DEFAULT '0' COMMENT 'harga modal',
  `stok` int(11) DEFAULT '0',
  `id_brand` varchar(16) DEFAULT NULL,
  `id_kategori` varchar(16) DEFAULT NULL,
  `deskripsi` text,
  `spesifikasi` text,
  `foto` varchar(50) DEFAULT NULL,
  `qr_produk` varchar(100) DEFAULT NULL COMMENT 'generate by sistem',
  `stok_gudang` int(11) DEFAULT '0',
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=aktif,0=tdk aktif',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_produk` */

insert  into `pos_produk`(`id_produk`,`jenis_data`,`sku`,`nama_produk`,`nominal`,`harga_modal`,`stok`,`id_brand`,`id_kategori`,`deskripsi`,`spesifikasi`,`foto`,`qr_produk`,`stok_gudang`,`flag_aktif`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('PRD3TD54AREWLQMHS624','stok','SN00101','Balol Kayu Jati 4 inch',20000,12000,215,'BRNKDXTQAF8E3443','KTGSXHGGHHY6N886','ok1','ok2','produk_PRD3TD54AREWLQMHS624_438.png','J4C8CJ8FR7TLYU9BRXTM',2000,1,'2020-04-21 17:50:43','USR11213453HGTTD','2020-05-11 00:28:47','USR11213453HGTTD'),('PRDB37GPHR8RQB3YR840','stok','SN0020202','Besi Nako 6 Inch',10000,8000,215,'BRNH4RCBWJBDN915','KTGJA3LGH83UB796','klhjlkhj','kjhguk','produk_PRDB37GPHR8RQB3YR840_399.png','SC8RTA6KXR89KBFYGTGJ',930,1,'2020-04-21 17:50:34','USR11213453HGTTD','2020-05-11 00:26:34','USR11213453HGTTD'),('PRDHXMWBVFN39YJR8917','stok','SN9393939','Besi Hollow Mek A',12000,9500,0,'BRNABNEFSLVCB427','KTGJA3LGH83UB796','makanan oke ','sip','produk_PRDHXMWBVFN39YJR8917_297.png','5JBU5F9SFMBP5DEJRBSR',2000,1,'2020-05-09 00:05:13','USR11213453HGTTD','2020-05-11 00:27:42','USR11213453HGTTD');

/*Table structure for table `pos_transaksi` */

DROP TABLE IF EXISTS `pos_transaksi`;

CREATE TABLE `pos_transaksi` (
  `id_pos_transaksi` varchar(20) NOT NULL COMMENT 'PTR',
  `jenis_data` varchar(25) DEFAULT 'piutang' COMMENT 'hutang,piutang',
  `no_invoice` varchar(30) DEFAULT NULL COMMENT 'POS/0420/00001',
  `tgl_invoice` date DEFAULT NULL,
  `total_nominal` double DEFAULT '0',
  `terms` smallint(3) DEFAULT '0',
  `batas_tempo` date DEFAULT NULL,
  `bill_to` varchar(16) DEFAULT NULL COMMENT 'client/vendor',
  `id_booking` varchar(16) DEFAULT NULL,
  `flag_ppn` smallint(1) DEFAULT '1' COMMENT '1=kena ppn,0=tidak',
  `flag_aktif` smallint(1) DEFAULT '1',
  `auto_inv` smallint(1) DEFAULT '1' COMMENT '1=otomatis no invoice',
  `flag_lunas` smallint(1) DEFAULT '1',
  `tgl_lunas` date DEFAULT NULL,
  `keterangan` text,
  `cash` double DEFAULT '0',
  `kembali` double DEFAULT '0',
  `id_po` varchar(16) DEFAULT NULL COMMENT 'lookup pos_po untuk pembelian',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_pos_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_transaksi` */

insert  into `pos_transaksi`(`id_pos_transaksi`,`jenis_data`,`no_invoice`,`tgl_invoice`,`total_nominal`,`terms`,`batas_tempo`,`bill_to`,`id_booking`,`flag_ppn`,`flag_aktif`,`auto_inv`,`flag_lunas`,`tgl_lunas`,`keterangan`,`cash`,`kembali`,`id_po`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('PTRKM3MH8W3C6LH8Q699','hutang','HT/2005/0001','2020-05-08',0,14,'2020-05-22','VNDJ6AWXVGKXX504',NULL,1,1,1,1,'2020-05-08',NULL,0,0,'PPONX88U7ALLG8GD','2020-05-08 16:40:42','USR11213453HGTTD',NULL,NULL),('PTRKU69J7P9BN9CH5772','hutang','HT/2005/0002','2020-05-08',0,0,'2020-05-08','VNDJ6AWXVGKXX504',NULL,1,1,1,1,'2020-05-08','ok',0,0,'PPO7U87W3XFTYVMU','2020-05-08 22:42:05','USR11213453HGTTD',NULL,NULL),('PTRPGW9NGA8EXUGBE670','piutang','INV/2005/00001','2020-05-08',165000,0,'2020-05-08',NULL,NULL,1,1,1,1,'2020-05-08',NULL,200000,35000,NULL,'2020-05-08 11:36:57','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `pos_transaksi_cicilan` */

DROP TABLE IF EXISTS `pos_transaksi_cicilan`;

CREATE TABLE `pos_transaksi_cicilan` (
  `id_transcicilan` varchar(20) NOT NULL COMMENT 'TRC',
  `id_pos_transaksi` varchar(20) DEFAULT NULL,
  `nominal` double DEFAULT '0',
  `id_bank` varchar(16) DEFAULT NULL,
  `flag_aktif` smallint(1) DEFAULT '1' COMMENT '1=aktif,0=tdk aktif',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_transcicilan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_transaksi_cicilan` */

/*Table structure for table `pos_transaksi_detail` */

DROP TABLE IF EXISTS `pos_transaksi_detail`;

CREATE TABLE `pos_transaksi_detail` (
  `id_transdet` varchar(20) NOT NULL COMMENT 'TRD',
  `id_pos_transaksi` varchar(20) DEFAULT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `jumlah` smallint(5) DEFAULT '0',
  `nominal` double DEFAULT '0',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_transdet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_transaksi_detail` */

insert  into `pos_transaksi_detail`(`id_transdet`,`id_pos_transaksi`,`id_produk`,`jumlah`,`nominal`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('TRD3NP75S99M94F74233','PTRKM3MH8W3C6LH8Q699','PRDB37GPHR8RQB3YR840',20,0,'2020-05-08 16:40:42','USR11213453HGTTD',NULL,NULL),('TRD5DYMVHYQ7WJ5GF767','PTRPGW9NGA8EXUGBE670','PRD3TD54AREWLQMHS624',5,20000,'2020-05-08 11:36:57','USR11213453HGTTD',NULL,NULL),('TRD8KF8YQKAMTA9WR891','PTRKU69J7P9BN9CH5772','PRD3TD54AREWLQMHS624',20,0,'2020-05-08 22:42:05','USR11213453HGTTD',NULL,NULL),('TRD98SU9EMVPSSMCQ603','PTRPGW9NGA8EXUGBE670','PRDB37GPHR8RQB3YR840',5,10000,'2020-05-08 11:36:57','USR11213453HGTTD',NULL,NULL),('TRDY8NVAY59JYLVSR684','PTRKU69J7P9BN9CH5772','PRDB37GPHR8RQB3YR840',50,0,'2020-05-08 22:42:05','USR11213453HGTTD',NULL,NULL);

/*Table structure for table `pos_vendor` */

DROP TABLE IF EXISTS `pos_vendor`;

CREATE TABLE `pos_vendor` (
  `id_vendor` varchar(16) NOT NULL COMMENT 'VND',
  `type_vendor` varchar(20) DEFAULT 'umum' COMMENT 'umum, default',
  `nama` varchar(100) DEFAULT NULL,
  `kategori_vendor` varchar(30) DEFAULT NULL COMMENT 'PT,CV,Perorangan,DLL...',
  `alamat` text,
  `no_hp` varchar(13) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `keterangan` text,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `user_update` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_vendor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pos_vendor` */

insert  into `pos_vendor`(`id_vendor`,`type_vendor`,`nama`,`kategori_vendor`,`alamat`,`no_hp`,`email`,`keterangan`,`tgl_input`,`user_input`,`tgl_update`,`user_update`) values ('VND3X67ALY7XX493','umum','PT. Nusa Media Amanah','PT','Jl. mawar melati no 22 Nusa Indah, Banjarmasin','0853763411110','susanto.wibowoo@gmail.com',NULL,'2020-05-02 00:22:27','AD78jh786hgt9897','2020-05-11 00:30:34','USR11213453HGTTD'),('VNDJ6AWXVGKXX504','umum','Gudang Kantin','CV','Jl. mawar melati no 22 Nusa Indah, Banjarmasin','0853',NULL,NULL,'2020-05-07 10:57:20','USR11213453HGTTD','2020-05-11 00:30:18','USR11213453HGTTD'),('VNDJ7YXXLBQ6T340','umum','PT. ABC','PT','Jl. mawar melati no 22 Nusa Indah, Banjarmasin','08',NULL,NULL,'2020-05-02 00:33:08','AD78jh786hgt9897','2020-05-11 00:30:27','USR11213453HGTTD');

/*Table structure for table `setting_apps` */

DROP TABLE IF EXISTS `setting_apps`;

CREATE TABLE `setting_apps` (
  `id_setting` smallint(1) NOT NULL,
  `flag_maintenance` smallint(1) DEFAULT '1' COMMENT '0=dalam tahap maintenance',
  `meta_title` varchar(100) DEFAULT NULL,
  `meta_deskripsi` text,
  `meta_keyword` text,
  `logo_web` varchar(100) DEFAULT NULL,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `pimpinan` varchar(100) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `email_invoice` text,
  `flag_ppn` smallint(1) DEFAULT '1' COMMENT '1=kena ppn 10%',
  `default_vendor` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `setting_apps` */

insert  into `setting_apps`(`id_setting`,`flag_maintenance`,`meta_title`,`meta_deskripsi`,`meta_keyword`,`logo_web`,`nama_perusahaan`,`pimpinan`,`alamat`,`lokasi`,`email_invoice`,`flag_ppn`,`default_vendor`) values (1,1,'ERP - Juwita Group','x1','x2',NULL,'Juwita Group','NANA DIANITA, S.E.,M.M','Jl. Arifin Ahmad No. 11 Banjarmasin','Banjarmasin',NULL,1,'VNDJ6AWXVGKXX504');

/*Table structure for table `setup_mail` */

DROP TABLE IF EXISTS `setup_mail`;

CREATE TABLE `setup_mail` (
  `id_setup` smallint(1) NOT NULL AUTO_INCREMENT,
  `alias_name` varchar(100) DEFAULT NULL,
  `from_sending` varchar(100) DEFAULT NULL COMMENT '@namaemail.com',
  `protocol` varchar(20) DEFAULT 'smtp',
  `smtp_user` varchar(100) DEFAULT NULL COMMENT '@namaemail.com',
  `smtp_pass` varchar(100) DEFAULT NULL,
  `smtp_host` varchar(100) DEFAULT NULL COMMENT 'mail.namadomain.com',
  `smtp_port` varchar(10) DEFAULT '587' COMMENT 'default=587',
  PRIMARY KEY (`id_setup`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `setup_mail` */

insert  into `setup_mail`(`id_setup`,`alias_name`,`from_sending`,`protocol`,`smtp_user`,`smtp_pass`,`smtp_host`,`smtp_port`) values (1,'noreply','email@gmail.com','smtp','email@gmail.com','email2020','smtp.gmail.com','587');

/*Table structure for table `tbl_log_login` */

DROP TABLE IF EXISTS `tbl_log_login`;

CREATE TABLE `tbl_log_login` (
  `id_user` varchar(16) DEFAULT NULL,
  `tgl_login` datetime DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_log_login` */

/*Table structure for table `tbl_log_manufacture` */

DROP TABLE IF EXISTS `tbl_log_manufacture`;

CREATE TABLE `tbl_log_manufacture` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_manufacture` varchar(16) DEFAULT NULL,
  `flag_log` smallint(1) DEFAULT '1' COMMENT '1=setuju, 0=tolak',
  `keterangan` varchar(100) DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_log_manufacture` */

/*Table structure for table `tmp_pos` */

DROP TABLE IF EXISTS `tmp_pos`;

CREATE TABLE `tmp_pos` (
  `id_tmp` varchar(16) NOT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `jumlah` int(11) DEFAULT '1',
  `nominal` double DEFAULT '0',
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tmp_pos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
